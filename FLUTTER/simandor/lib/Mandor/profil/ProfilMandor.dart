import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:simandor/LoginMandor.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:simandor/Mandor/profil/EditProfil.dart';


class ProfilMandor extends StatefulWidget {
  final String id_user;
  final String username;
  final String namaLengkap;
  final String alamat;
  final String password;
  final String level;
   final String foto;

  ProfilMandor({
    required this.id_user,
    required this.username,
    required this.namaLengkap,
    required this.alamat,
    required this.password,
    required this.level,
    required this.foto,
  });

  @override
  State<ProfilMandor> createState() => _ProfilMandorState();
}

class _ProfilMandorState extends State<ProfilMandor> {
  late String _username;
  late String _namaLengkap;
  late String _alamat;
  late String _password;
  late String _level;
  late String _foto;
  // final ImagePicker _picker = ImagePicker();
  // File? _imageFile;

  @override
  void initState() {
    super.initState();
    _username = widget.username;
    _namaLengkap = widget.namaLengkap;
    _alamat = widget.alamat;
    _password = widget.password;
    _level = widget.level;
     _foto = widget.foto;
  }

// Future<void> _pickImage() async {
//     try {
//       final pickedFile = await _picker.pickImage(source: ImageSource.gallery);

//       setState(() {
//         if (pickedFile != null) {
//           _imageFile = File(pickedFile.path);
//         }
//       });

//       if (_imageFile != null) {
//         _uploadImage(_imageFile!);
//       }
//     } catch (e) {
//       print("Error picking image: $e");
//       ScaffoldMessenger.of(context).showSnackBar(
//         SnackBar(content: Text('Failed to pick image')),
//       );
//     }
//   }

//     Future<void> _uploadImage(File image) async {
//     final uri = Uri.parse('http://192.168.200.207/si_mandor/upload_foto.php');
//     var request = http.MultipartRequest('POST', uri);
//     request.files.add(await http.MultipartFile.fromPath('foto', image.path));
//     request.fields['id_user'] = widget.id_user;

//     var response = await request.send();

//     if (response.statusCode == 200) {
//       var responseData = await http.Response.fromStream(response);
//       var data = json.decode(responseData.body);
//       if (data['status'] == 'success') {
//         setState(() {
//           _foto = data['foto'];
//         });
//         ScaffoldMessenger.of(context).showSnackBar(
//           SnackBar(content: Text(data['message'])),
//         );
//       } else {
//         ScaffoldMessenger.of(context).showSnackBar(
//           SnackBar(content: Text(data['message'])),
//         );
//       }
//     } else {
//       ScaffoldMessenger.of(context).showSnackBar(
//         SnackBar(content: Text('Gagal mengunggah foto')),
//       );
//     }
//   }
Future<void> _logout() async {
    final response = await http.post(Uri.parse('http://192.168.93.207/si_mandor/logout.php'));
    
    if (response.statusCode == 200) {
      final responseBody = json.decode(response.body);
      if (responseBody['status'] == 'success') {
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (context) => LoginPage()),
        );
      } else {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text(responseBody['message'])),
        );
      }
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Gagal melakukan logout')),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        backgroundColor: Colors.black12,
        body: ListView(
          padding: const EdgeInsets.all(20),
          children: [
          //   GestureDetector(
          //   child: CircleAvatar(
          //     radius: 60,
          //     backgroundImage: _foto.isNotEmpty
          //         ? NetworkImage('http://192.168.77.207/si_mandor/upload_foto.php/$_foto')
          //         : null,
          //     child: _foto.isEmpty
          //         ? Icon(Icons.add_a_photo, size: 40, color: Colors.white)
          //         : null,
          //   ),
          // ),
            SizedBox(
              height: 20,
            ),
            Container(
              decoration: BoxDecoration(
                  borderRadius: BorderRadius.circular(10), color: Colors.white),
              child: ListTile(
                title: Text('$_namaLengkap'),
                leading: Icon(Icons.person),
              ),
            ),
            SizedBox(
              height: 20,
            ),
            Container(
              decoration: BoxDecoration(
                  borderRadius: BorderRadius.circular(10), color: Colors.white),
              child: ListTile(
                title: Text('$_alamat'),
                leading: Icon(Icons.location_city),
              ),
            ),
            SizedBox(
              height: 20,
            ),
            Container(
              decoration: BoxDecoration(
                  borderRadius: BorderRadius.circular(10), color: Colors.white),
              child: ListTile(
                title: Text('$_username'),
                leading: Icon(Icons.person),
              ),
            ),
            SizedBox(
              height: 20,
            ),
            Container(
              decoration: BoxDecoration(
                  borderRadius: BorderRadius.circular(10), color: Colors.white),
              child: ListTile(
                title: Text('$_password'),
                leading: Icon(Icons.key),
              ),
            ),
            SizedBox(
              height: 20,
            ),
            Container(
              decoration: BoxDecoration(
                  borderRadius: BorderRadius.circular(10), color: Colors.white),
              child: ListTile(
                title: Text('$_level'),
                leading: Icon(Icons.person),
              ),
            ),
            SizedBox(
              height: 20,
            ),
            Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
              ElevatedButton(
                onPressed: () async {
                  final updatedUser = await Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (context) => EditProfilMandor(
                        id_user: widget.id_user,
                        username: _username,
                        namaLengkap: _namaLengkap,
                        alamat: _alamat,
                        password: _password,
                        level: _level,
                        foto: _foto,
                      ),
                    ),
                  );
                  if (updatedUser != null) {
                    setState(() {
                      _username = updatedUser['username'];
                      _namaLengkap = updatedUser['nama_lengkap'];
                      _alamat = updatedUser['alamat'];
                      _password = updatedUser['password'];
                      _level = updatedUser['level'];
                    });
                  }
                },
                style: ElevatedButton.styleFrom(
                  backgroundColor: Color.fromARGB(255, 50, 243, 137),
                  fixedSize: Size(150, 40),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10),
                  ),
                ),
                child: Text(
                  'Edit',
                  style: TextStyle(color: Colors.black),
                ),
              ),
            ],
            ),
            SizedBox(
              height: 20,
            ),
            Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                ElevatedButton(
                  onPressed: _logout,
                  style: ElevatedButton.styleFrom(
                      backgroundColor: Color.fromARGB(255, 50, 243, 137),
                      fixedSize: Size(150, 40),
                      shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(10)),
                      padding: EdgeInsets.all(15)),
                  child: Text(
                    'Log Out',
                    style: TextStyle(color: Colors.black),
                  ),
                ),
              ],
            ),
          ],
        ));
  }
}
