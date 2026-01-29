package com.a2411500076.tokosepatu

import android.os.Bundle
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import java.net.HttpURLConnection
import java.net.URL

class AddSepatuActivity : AppCompatActivity() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_add_sepatu)

        val etNama   = findViewById<EditText>(R.id.etNama)
        val etMerek  = findViewById<EditText>(R.id.etMerek)
        val etUkuran = findViewById<EditText>(R.id.etUkuran)
        val etTahun  = findViewById<EditText>(R.id.etTahun)
        val etStok   = findViewById<EditText>(R.id.etStok)
        val etGambar = findViewById<EditText>(R.id.etGambar)
        val btnSimpan = findViewById<Button>(R.id.btnSimpan)

        btnSimpan.setOnClickListener {
            postSepatu(
                etNama.text.toString(),
                etMerek.text.toString(),
                etUkuran.text.toString(),
                etTahun.text.toString(),
                etStok.text.toString(),
                etGambar.text.toString()
            )
        }
    }

    private fun postSepatu(
        nama: String,
        merek: String,
        ukuran: String,
        tahun: String,
        stok: String,
        gambar: String
    ) {
        Thread {
            try {
                val url = URL("http://10.219.223.13/tokosepatu/api/sepatu_post.php")
                val conn = url.openConnection() as HttpURLConnection
                conn.requestMethod = "POST"
                conn.doOutput = true
                conn.setRequestProperty(
                    "Content-Type",
                    "application/x-www-form-urlencoded"
                )

                val data =
                    "nama_sepatu=${java.net.URLEncoder.encode(nama, "UTF-8")}" +
                            "&merek=${java.net.URLEncoder.encode(merek, "UTF-8")}" +
                            "&ukuran=${java.net.URLEncoder.encode(ukuran, "UTF-8")}" +
                            "&tahun_rilis=${java.net.URLEncoder.encode(tahun, "UTF-8")}" +
                            "&stok=${java.net.URLEncoder.encode(stok, "UTF-8")}" +
                            "&gambar_sepatu=${java.net.URLEncoder.encode(gambar, "UTF-8")}"

                conn.outputStream.use {
                    it.write(data.toByteArray())
                }

                val response = conn.inputStream.bufferedReader().readText()
                println("RESPONSE POST = $response")

                runOnUiThread {
                    Toast.makeText(this, "Data berhasil disimpan", Toast.LENGTH_SHORT).show()
                    finish()
                }

            } catch (e: Exception) {
                e.printStackTrace()
                runOnUiThread {
                    Toast.makeText(this, "Gagal menyimpan data", Toast.LENGTH_SHORT).show()
                }
            }
        }.start()
    }
}
