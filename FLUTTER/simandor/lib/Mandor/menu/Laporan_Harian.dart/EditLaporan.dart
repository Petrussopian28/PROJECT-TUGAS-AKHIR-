import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:intl/intl.dart';
import 'dart:async';

import 'package:simandor/Mandor/RiwayatLaporan.dart';

class EditLaporan extends StatefulWidget {
  final String id_user;
  final Map<String, dynamic> laporan;

  EditLaporan({required this.id_user, required this.laporan});

  @override
  _EditLaporanState createState() => _EditLaporanState();
}

class _EditLaporanState extends State<EditLaporan> {
  final _formKey = GlobalKey<FormState>();
  TextEditingController datetimeinputController = TextEditingController();
  TextEditingController absensiController = TextEditingController();
  TextEditingController luasController = TextEditingController();
  TextEditingController janjangController = TextEditingController();
  TextEditingController catatanController = TextEditingController();

  List<dynamic> divisiList = [];
  List<dynamic> blokList = [];
  List<dynamic> karyawanList = [];

  String? selectedDivisi;
  String? selectedBlok;
  String? selectedKaryawan;

  @override
  void initState() {
    super.initState();
    _fetchOptions();
    _populateFields();
  }

  void _populateFields() {
    datetimeinputController.text = widget.laporan['datetimeinput'];
    absensiController.text = widget.laporan['absensi'];
    luasController.text = widget.laporan['luas'];
    janjangController.text = widget.laporan['janjang'];
    catatanController.text = widget.laporan['catatan'];
    selectedDivisi = widget.laporan['id_divisi'];
    selectedBlok = widget.laporan['id_blok'];
    selectedKaryawan = widget.laporan['id_karyawan'];
  }

  Future<void> _fetchOptions() async {
    final response = await http
        .get(Uri.parse('http://192.168.93.207/si_mandor/get_data.php'));
    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      setState(() {
        divisiList = data['divisi'];
        blokList = data['blok'];
        karyawanList = data['karyawan'];
        // Ensure the selected values are valid
        if (!divisiList.any((item) => item['id_divisi'].toString() == selectedDivisi)) {
          selectedDivisi = null;
        }
        if (!blokList.any((item) => item['id_blok'].toString() == selectedBlok)) {
          selectedBlok = null;
        }
        if (!karyawanList.any((item) => item['id_karyawan'].toString() == selectedKaryawan)) {
          selectedKaryawan = null;
        }
      });
    } else {
      throw Exception('Failed to load options');
    }
  }

  Future<void> _submitReport() async {
    if (_formKey.currentState!.validate()) {
      final response = await http.post(
        Uri.parse(
            'http://192.168.93.207/si_mandor/editlaporan.php?id_laporan=${widget.laporan['id_laporan']}'),
        body: {
          'datetimeinput': datetimeinputController.text,
          'absensi': absensiController.text,
          'luas': luasController.text,
          'janjang': janjangController.text,
          'catatan': catatanController.text,
          'id_user': widget.id_user,
          'id_divisi': selectedDivisi,
          'id_blok': selectedBlok,
          'id_karyawan': selectedKaryawan,
        },
      );

      final responseMessage = json.decode(response.body);
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(responseMessage['message'])),
      );
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (context) => RiwayatLaporan(id_user: widget.id_user)),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.green,
        title: Text('Edit Laporan Harian'),
      ),
      body: Padding(
        padding: EdgeInsets.all(16.0),
        child: Form(
          key: _formKey,
          child: ListView(
            children: <Widget>[
              Padding(
                padding: EdgeInsets.only(top: 10.0),
              ),
              Padding(
                padding: EdgeInsets.only(top: 10.0),
              ),
              TextFormField(
                controller: datetimeinputController,
                decoration: InputDecoration(
                  hintText: "Tanggal",
                  labelText: "Tanggal",
                  border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(10.0)),
                ),
                onTap: () async {
                  DateTime? pickedDate = await showDatePicker(
                    context: context,
                    initialDate: DateTime.now(),
                    firstDate: DateTime(2000),
                    lastDate: DateTime(2100),
                  );
                  if (pickedDate != null) {
                    String formatDate =
                        DateFormat('yyyy-MMM-dd').format(pickedDate);
                    setState(() {
                      datetimeinputController.text = formatDate;
                    });
                  } else {
                    print("tanggal tidak dipilih");
                    datetimeinputController.text = "";
                  }
                },
                validator: (value) {
                  if (value!.isEmpty) {
                    return 'Harap masukkan tanggal';
                  }
                  return null;
                },
              ),
              Padding(
                padding: EdgeInsets.only(top: 10.0),
              ),
              DropdownButtonFormField<String>(
                value: selectedKaryawan,
                decoration: InputDecoration(
                  labelText: "Nama Karyawan",
                  border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(10.0)),
                ),
                hint: Text('Pilih Karyawan'),
                onChanged: (newValue) {
                  setState(() {
                    selectedKaryawan = newValue;
                  });
                },
                items: karyawanList.map((karyawan) {
                  return DropdownMenuItem<String>(
                    value: karyawan['id_karyawan'].toString(),
                    child: Text(karyawan['nama_karyawan']),
                  );
                }).toList(),
                validator: (value) =>
                    value == null ? 'Harap pilih Karyawan' : null,
              ),
              Padding(
                padding: EdgeInsets.only(top: 10.0),
              ),
              TextFormField(
                controller: absensiController,
                decoration: InputDecoration(
                  labelText: 'Absensi',
                  border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(10.0)),
                ),
                validator: (value) {
                  if (value!.isEmpty) {
                    return 'Harap masukkan absensi';
                  }
                  return null;
                },
              ),
              Padding(
                padding: EdgeInsets.only(top: 10.0),
              ),
              DropdownButtonFormField<String>(
                value: selectedDivisi,
                decoration: InputDecoration(
                  labelText: "Nama Divisi",
                  border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(10.0)),
                ),
                hint: Text('Pilih Divisi'),
                onChanged: (newValue) {
                  setState(() {
                    selectedDivisi = newValue;
                  });
                },
                items: divisiList.map((divisi) {
                  return DropdownMenuItem<String>(
                    value: divisi['id_divisi'].toString(),
                    child: Text(divisi['nama_divisi']),
                  );
                }).toList(),
                validator: (value) =>
                    value == null ? 'Harap pilih Divisi' : null,
              ),
              Padding(
                padding: EdgeInsets.only(top: 10.0),
              ),
              DropdownButtonFormField<String>(
                value: selectedBlok,
                decoration: InputDecoration(
                  labelText: "Nama Blok",
                  border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(10.0)),
                ),
                hint: Text('Pilih Blok'),
                onChanged: (newValue) {
                  setState(() {
                    selectedBlok = newValue;
                  });
                },
                items: blokList.map((blok) {
                  return DropdownMenuItem<String>(
                    value: blok['id_blok'].toString(),
                    child: Text(blok['nama_blok']),
                  );
                }).toList(),
                validator: (value) =>
                    value == null ? 'Harap pilih Blok' : null,
              ),
              Padding(
                padding: EdgeInsets.only(top: 10.0),
              ),
              TextFormField(
                controller: luasController,
                decoration: InputDecoration(
                  labelText: 'Luas',
                  border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(10.0)),
                ),
                validator: (value) {
                  if (value!.isEmpty) {
                    return 'Harap masukkan luas';
                  }
                  return null;
                },
              ),
              Padding(
                padding: EdgeInsets.only(top: 10.0),
              ),
              TextFormField(
                controller: janjangController,
                decoration: InputDecoration(
                  labelText: 'Janjang',
                  border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(10.0)),
                ),
                validator: (value) {
                  if (value!.isEmpty) {
                    return 'Harap masukkan janjang';
                  }
                  return null;
                },
              ),
              Padding(
                padding: EdgeInsets.only(top: 10.0),
              ),
              TextFormField(
                controller: catatanController,
                decoration: InputDecoration(
                  labelText: 'Catatan',
                  border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(10.0)),
                ),
              ),
              SizedBox(height: 20),
              
              ElevatedButton(
                onPressed: () {
                  _submitReport();
                },
                style: ElevatedButton.styleFrom(
                        backgroundColor: Color.fromARGB(255, 50, 243, 137),
                        fixedSize: Size(150, 40),
                        shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(10)),
                        padding: EdgeInsets.all(15)),
                child: Text('Edit', style: TextStyle(color: Colors.black), ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
