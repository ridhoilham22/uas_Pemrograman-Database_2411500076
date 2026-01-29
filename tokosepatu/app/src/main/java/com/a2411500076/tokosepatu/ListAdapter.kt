package com.a2411500076.tokosepatu

import android.content.Context
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.BaseAdapter
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide

class ListAdapter(
    private val context: Context,
    private var items: MutableList<ListItem>
) : BaseAdapter() {

    override fun getCount(): Int = items.size

    override fun getItem(position: Int): Any = items[position]

    override fun getItemId(position: Int): Long = items[position].id_sepatu.toLong()

    override fun getView(position: Int, convertView: View?, parent: ViewGroup?): View {
        val view: View
        val holder: ViewHolder

        if (convertView == null) {
            view = LayoutInflater.from(context).inflate(R.layout.items_list, parent, false)
            holder = ViewHolder()
            holder.namaTextView = view.findViewById(R.id.namaTextView)
            holder.merekTextView = view.findViewById(R.id.merekTextView)
            holder.gambarImageView = view.findViewById(R.id.gambarImageView)
            view.tag = holder
        } else {
            view = convertView
            holder = convertView.tag as ViewHolder
        }

        val item = items[position]
        holder.namaTextView?.text = item.nama_sepatu
        holder.merekTextView?.text = item.merek
        Glide.with(context)
            .load(item.gambar_sepatu)
            .into(holder.gambarImageView!!)

        return view
    }

    fun updateList(newItems: MutableList<ListItem>) {
        items = newItems
        notifyDataSetChanged()
    }

    private class ViewHolder {
        var namaTextView: TextView? = null
        var merekTextView: TextView? = null
        var gambarImageView: ImageView? = null
    }
}
