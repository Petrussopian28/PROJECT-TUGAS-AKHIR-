import 'package:flutter/material.dart';
import 'package:simandor/Mandor/BerandaMandor.dart';
import 'package:simandor/Mandor/RiwayatLaporan.dart';
import 'package:simandor/Mandor/profil/ProfilMandor.dart';

class HomePageMandor extends StatefulWidget {

  final String id_user;
  final String username;
  final String namaLengkap;
  final String alamat;
  final String password;
  final String level;
  final String foto;

  HomePageMandor({
    required this.id_user,
    required this.username,
    required this.namaLengkap,
    required this.alamat,
    required this.password,
    required this.level,
    required this.foto,
  });

  @override
  State<HomePageMandor> createState() => _HomePageMandorState();
}

class _HomePageMandorState extends State<HomePageMandor> {
  int currentIndex = 0;
  


  @override
  Widget build(BuildContext context) {
    final List<Widget> body = [
    BerandaMandor(
      id_user: widget.id_user,
      username: widget.username, 
      namaLengkap: widget.namaLengkap,
      alamat:widget.alamat,
      password:widget.password,
      level:widget.level,
      ),
    RiwayatLaporan(id_user: widget.id_user),
    ProfilMandor(id_user: widget.id_user,
      username: widget.username, 
      namaLengkap: widget.namaLengkap,
      alamat:widget.alamat,
      password:widget.password,
      level:widget.level,
      foto:widget.foto,
      ),
  ];
    return Scaffold(
      body: body[currentIndex],
      bottomNavigationBar:
          BottomNavigationBar(onTap: ontap, currentIndex: currentIndex, items: [
        BottomNavigationBarItem(
            icon: Icon(
              Icons.home,
              color: Colors.green,
            ),
            label: 'Beranda',
            activeIcon: Icon(
              Icons.home_outlined,
              color: Colors.amber,
            )),
        BottomNavigationBarItem(
            icon: Icon(
              Icons.notifications,
              color: Colors.green,
            ),
            label: 'Riwayat',
            activeIcon: Icon(
              Icons.notifications_sharp,
              color: Colors.amber,
            )),
        BottomNavigationBarItem(
            icon: Icon(
              Icons.person,
              color: Colors.green,
            ),
            label: 'Profil',
            activeIcon: Icon(
              Icons.person_outlined,
              color: Colors.amber,
            )),
      ]),
    );
  }
  void ontap(int index) {
    setState(() {
      currentIndex = index;
    });
  }

}