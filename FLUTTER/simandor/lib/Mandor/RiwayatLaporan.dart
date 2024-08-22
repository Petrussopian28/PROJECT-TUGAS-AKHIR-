import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:simandor/Mandor/menu/Laporan_Harian.dart/DetailLaporan.dart';
import 'package:simandor/Mandor/menu/Laporan_Harian.dart/EditLaporan.dart';
import 'dart:convert';


class RiwayatLaporan extends StatefulWidget {
  final String id_user;

  RiwayatLaporan({required this.id_user});

  @override
  _RiwayatLaporanState createState() => _RiwayatLaporanState();
}

class _RiwayatLaporanState extends State<RiwayatLaporan> {
  List<dynamic> laporanList = [];
  bool isLoading = true;
  bool hasError = false;
  String errorMessage = "";
  String searchQuery = "";

  @override
  void initState() {
    super.initState();
    _fetchLaporan();
  }

  Future<void> _fetchLaporan() async {
    final response = await http.get(Uri.parse(
        'http://192.168.93.207/si_mandor/viewlaporan.php?id_user=${widget.id_user}&search_query=$searchQuery'));

    if (response.statusCode == 200) {
      try {
        final jsonResponse = json.decode(response.body);
        if (jsonResponse is List) {
          setState(() {
            laporanList = jsonResponse;
            isLoading = false;
            errorMessage = "";
          });
        } else if (jsonResponse is Map<String, dynamic> &&
            jsonResponse.containsKey('message')) {
          setState(() {
            errorMessage = jsonResponse['message'];
            laporanList = [];
            isLoading = false;
            hasError = true;
          });
        } else {
          setState(() {
            errorMessage = "Response tidak sesuai format yang diharapkan";
            laporanList = [];
            isLoading = false;
            hasError = true;
          });
        }
      } catch (e) {
        setState(() {
          errorMessage = "Terjadi kesalahan dalam memproses data";
          laporanList = [];
          isLoading = false;
          hasError = true;
        });
      }
    } else {
      setState(() {
        errorMessage = 'Gagal memuat laporan: ${response.statusCode}';
        isLoading = false;
        hasError = true;
      });
    }
  }

  Future<void> deleteLaporan(String idLaporan) async {
    try {
      final response = await http.post(
        Uri.parse('http://192.168.93.207/si_mandor/hapuslaporan.php'),
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: {'id_laporan': idLaporan},
      );

      if (response.statusCode == 200) {
        final jsonResponse = json.decode(response.body);
        print(response.body);
        if (jsonResponse['message'] == 'Laporan berhasil dihapus') {
          _fetchLaporan(); // Refresh laporan setelah berhasil hapus
        } else {
          setState(() {
            errorMessage = jsonResponse['message'] ?? "Terjadi kesalahan";
            hasError = true;
          });
        }
      } else {
        setState(() {
          errorMessage = 'Gagal menghapus laporan: ${response.statusCode}';
          hasError = true;
        });
      }
    } catch (e) {
      setState(() {
        errorMessage = "Terjadi kesalahan dalam menghapus laporan: $e";
        hasError = true;
      });
    }
  }
  void _onSearchChanged(String query) {
    setState(() {
      searchQuery = query;
      isLoading = true;
      hasError = false;
      errorMessage = "";
      _fetchLaporan();
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        automaticallyImplyLeading: false,
        backgroundColor: Colors.green,
        elevation: 4.0,
        centerTitle: true,
        title: Container(
          width: double.infinity,
          height: 40,
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(5.0),
          ),
          alignment: Alignment.center, // Pusatkan kontainer
          child: TextFormField(
            decoration: InputDecoration(
              hintText: 'Cari Laporan',
              border: InputBorder.none,
              prefixIcon: Icon(Icons.search),
              contentPadding: EdgeInsets.only(left: 10.0, top: 10.0),
            ),
            onChanged: _onSearchChanged,
          ),
        ),
      ),
      body: isLoading
          ? Center(child: CircularProgressIndicator())
          : hasError
              ? Center(child: Text(errorMessage))
              : ListView.builder(
                  itemCount: laporanList.length,
                  itemBuilder: (context, index) {
                    return Card(
                      margin: EdgeInsets.symmetric(vertical: 8, horizontal: 16),
                      child: InkWell(
                        onTap: () {
                          Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder: (context) => DetailLaporan(
                                laporan: laporanList[index],
                              ),
                            ),
                          );
                        },
                        child: ListTile(
                          title: Text(
                              'Laporan ${laporanList[index]['datetimeinput']}'),
                          subtitle: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text(
                                  'Karyawan: ${laporanList[index]['nama_karyawan'] ?? "Tidak ada nama"}'),
                              Text(
                                  'Divisi: ${laporanList[index]['nama_divisi'] ?? "Tidak ada divisi"}'),
                            ],
                          ),
                          trailing: Row(
                            mainAxisSize: MainAxisSize.min,
                            children: [
                              IconButton(
                                icon: Icon(Icons.edit),
                                onPressed: () {
                                  Navigator.push(
                                    context,
                                    MaterialPageRoute(
                                      builder: (context) => EditLaporan(
                                        id_user: widget.id_user,
                                        laporan: {
                                          'id_laporan': laporanList[index]['id_laporan'].toString(),
                                          'datetimeinput': laporanList[index]['datetimeinput'].toString(),
                                          'absensi': laporanList[index]['absensi'].toString(),
                                          'luas': laporanList[index]['luas'].toString(),
                                          'janjang': laporanList[index]['janjang'].toString(),
                                          'catatan': laporanList[index]['catatan'].toString(),
                                          'nama_divisi': laporanList[index]['nama_divisi'].toString(),
                                          'nama_blok': laporanList[index]['nama_blok'].toString(),
                                          'nama_karyawan': laporanList[index]['nama_karyawan'].toString(),
                                          'id_divisi': laporanList[index]['id_divisi'].toString(),
                                          'id_blok': laporanList[index]['id_blok'].toString(),
                                          'id_karyawan': laporanList[index]['id_karyawan'].toString(),
                                        },
                                      ),
                                    ),
                                  );
                                },
                              ),
                              IconButton(
                                icon: Icon(Icons.delete),
                                onPressed: () {
                                  showDialog(
                                    barrierDismissible: false,
                                    context: context,
                                    builder: (BuildContext context) {
                                      return AlertDialog(
                                        title: Text('Hapus Laporan'),
                                        content: Text(
                                            'Apakah Anda yakin ingin menghapus laporan ini?'),
                                        actions: [
                                          TextButton(
                                            child: Text('Batal'),
                                            onPressed: () {
                                              Navigator.of(context).pop();
                                            },
                                          ),
                                          TextButton(
                                            child: Text('Hapus'),
                                            onPressed: () {
                                              deleteLaporan(laporanList[index]
                                                      ['id_laporan'].toString())
                                                  .then((value) {
                                                Navigator.pushAndRemoveUntil(
                                                    context,
                                                    MaterialPageRoute(
                                                        builder: ((context) =>
                                                            RiwayatLaporan(
                                                                id_user: widget
                                                                    .id_user))),
                                                    (route) => false);
                                              });
                                            },
                                          ),
                                        ],
                                      );
                                    },
                                  );
                                },
                              ),
                            ],
                          ),
                        ),
                      ),
                    );
                  },
                ),
    );
  }
}
