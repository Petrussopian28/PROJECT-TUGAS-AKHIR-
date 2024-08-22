import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class EditProfilMandor extends StatefulWidget {
  final String id_user;
  final String username;
  final String namaLengkap;
  final String alamat;
  final String password;
  final String level;
  final String foto;

  EditProfilMandor({
    required this.id_user,
    required this.username,
    required this.namaLengkap,
    required this.alamat,
    required this.password,
    required this.level,
    required this.foto,
  });

  @override
  _EditProfilMandorState createState() => _EditProfilMandorState();
}

class _EditProfilMandorState extends State<EditProfilMandor> {
  late TextEditingController _usernameController;
  late TextEditingController _namaLengkapController;
  late TextEditingController _alamatController;
  late TextEditingController _passwordController;
  late TextEditingController _levelController;

  @override
  void initState() {
    super.initState();
    _usernameController = TextEditingController(text: widget.username);
    _namaLengkapController = TextEditingController(text: widget.namaLengkap);
    _alamatController = TextEditingController(text: widget.alamat);
    _passwordController = TextEditingController(text: widget.password);
    _levelController = TextEditingController(text: widget.level);
  }

  Future<void> _saveChanges() async {
    final response = await http.post(
      Uri.parse('http://192.168.93.207/si_mandor/editprofil.php'),
      body: {
        'id_user': widget.id_user,
        'username': _usernameController.text,
        'nama_lengkap': _namaLengkapController.text,
        'alamat': _alamatController.text,
        'password': _passwordController.text,
        'level': _levelController.text,
      },
    );

    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      if (data['status'] == 'success') {
        Navigator.pop(context, data['user']);
      } else {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text(data['message'])),
        );
      }
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Gagal memperbarui profil')),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.green,
        title: Text('Edit Profil')),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            TextField(
              controller: _usernameController,
              decoration: InputDecoration(labelText: 'Username'),
            ),
            TextField(
              controller: _namaLengkapController,
              decoration: InputDecoration(labelText: 'Nama Lengkap'),
            ),
            TextField(
              controller: _alamatController,
              decoration: InputDecoration(labelText: 'Alamat'),
            ),
            TextField(
              controller: _passwordController,
              decoration: InputDecoration(labelText: 'Password'),
              obscureText: true,
            ),
            TextField(
              controller: _levelController,
              decoration: InputDecoration(labelText: 'Level'),
            ),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: _saveChanges,
              style: ElevatedButton.styleFrom(
                  backgroundColor: Color.fromARGB(255, 50, 243, 137),
                  fixedSize: Size(150, 40),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10),
                  ),
                ),
              child: Text('Simpan',style: TextStyle(color: Colors.black), ),
            ),
          ],
        ),
      ),
    );
  }
}
