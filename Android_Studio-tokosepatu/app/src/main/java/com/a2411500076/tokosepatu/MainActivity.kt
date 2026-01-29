package com.a2411500076.tokosepatu

import android.content.Intent
import android.widget.Button
import android.os.Bundle
import android.text.Editable
import android.widget.EditText
import android.widget.ListView
import android.text.TextWatcher
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.ViewCompat
import androidx.core.view.WindowInsetsCompat
import org.json.JSONObject
import java.net.HttpURLConnection
import java.net.URL

data class ListItem(val id_sepatu: Int, val nama_sepatu: String, val merek: String, val gambar_sepatu: String)

class MainActivity : AppCompatActivity() {

    private lateinit var btnAdd: Button
    private lateinit var listView: ListView
    private lateinit var listAdapter: ListAdapter
    private lateinit var searchEditText: EditText

    private val allItems = ArrayList<ListItem>()
    private var filteredItems = ArrayList(allItems)

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_main)

        btnAdd = findViewById(R.id.btnAdd)

        btnAdd.setOnClickListener {
            val intent = Intent(this, AddSepatuActivity::class.java)
            startActivity(intent)
        }

        listView = findViewById(R.id.listview)
        searchEditText = findViewById(R.id.searchEditText)

        listAdapter = ListAdapter(this, filteredItems)
        listView.adapter = listAdapter

        fetchBooksFromAPI()

        searchEditText.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(s: CharSequence?, start: Int, count: Int, after: Int) {}

            override fun onTextChanged(s: CharSequence?, start: Int, before: Int, count: Int) {
                filterList(query = s.toString())
            }

            override fun afterTextChanged(s: Editable?) {}
        })

        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main)) { v, insets ->
            val systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars())
            v.setPadding(
                systemBars.left,
                systemBars.top,
                systemBars.right,
                systemBars.bottom
            )
            insets
        }
    }

    private fun fetchBooksFromAPI() {
        Thread {
            try {
                val url = URL("http://10.219.223.13/tokosepatu/api/sepatu.php")
                val conn = url.openConnection() as HttpURLConnection
                conn.requestMethod = "GET" //
                conn.connect()

                val responseBody = conn.inputStream.bufferedReader().use { it.readText() }
                println("RESPONSE API = $responseBody")
                val json = JSONObject(responseBody)
                val dataArray = json.getJSONArray("data")

                val tempList = ArrayList<ListItem>()

                for (i in 0 until dataArray.length()) {
                    val o = dataArray.getJSONObject(i)
                    tempList.add(
                        ListItem(
                            id_sepatu = o.getString("id_sepatu").toInt(),
                            nama_sepatu = o.getString("nama_sepatu"),
                            merek = o.getString("merek"),
                            gambar_sepatu = o.getString("gambar_sepatu")
                        )
                    )
                }
                println("jumlah DATA = ${tempList.size}")

                runOnUiThread {
                    allItems.clear()
                    allItems.addAll(tempList)

                    filteredItems.clear()
                    filteredItems.addAll(tempList)
                    listAdapter.updateList(filteredItems)
                }

            } catch (e: Exception) {
                e.printStackTrace()
            }
        } .start()
    }


    private fun filterList(query: String) {
        val filteredList = if (query.isEmpty()) {
            allItems
        } else {
            allItems.filter { item ->
                item.nama_sepatu.contains(other = query, ignoreCase = true) ||
                        item.merek.contains(other = query, ignoreCase = true)
            }
        }
        listAdapter.updateList(newItems = ArrayList(filteredList))
    }
    override fun onResume() {
        super.onResume()
        fetchBooksFromAPI()
    }

}
