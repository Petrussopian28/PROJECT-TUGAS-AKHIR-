
import 'package:flutter/material.dart';

class DetailLaporan extends StatelessWidget {
  final Map<String, dynamic> laporan;

  DetailLaporan({required this.laporan});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Detail Laporan'),
        backgroundColor: Colors.green,
      ),
      body: Padding(
        padding: EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text('id Laporan: ${laporan['id_laporan']}'),
            Text('Tanggal Laporan: ${laporan['datetimeinput']}'),
            SizedBox(height: 8),
            Text('Karyawan: ${laporan['nama_karyawan']}'),
            SizedBox(height: 8),
            Text('Divisi: ${laporan['nama_divisi']}'),
            SizedBox(height: 8),
            Text('Blok: ${laporan['nama_blok']}'),
            SizedBox(height: 8),
            Text('Absensi: ${laporan['absensi']}'),
            SizedBox(height: 8),
            Text('Luas: ${laporan['luas']}'),
            SizedBox(height: 8),
            Text('Janjang: ${laporan['janjang']}'),
            SizedBox(height: 8),
            Text('Catatan: ${laporan['catatan']}'),
          ],
        ),
      ),
    );
  }
}
