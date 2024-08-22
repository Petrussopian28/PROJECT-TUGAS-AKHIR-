
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'package:simandor/Mandor/menu/Laporan_Harian.dart/TambahLaporan.dart';

class BerandaMandor extends StatelessWidget {
  final String id_user;
  final String username;
  final String namaLengkap;
  final String alamat;
  final String password;
  final String level;
  const BerandaMandor({
    required this.id_user,
    required this.username,
    required this.namaLengkap,
    required this.alamat,
    required this.password,
    required this.level,
  });
  


  @override
  Widget build(BuildContext context) {
    
    String formattedDate = DateFormat('EEEE, dd MMMM yyyy').format(DateTime.now());
    return Scaffold(
      body: ListView(
        padding: EdgeInsets.zero,
        children: [
          Container(
            decoration: BoxDecoration(
                color: Colors.green,
                borderRadius:
                    const BorderRadius.only(bottomRight: Radius.circular(30))),
            child: Column(children: [
              const SizedBox(height: 30),
              ListTile(
                  contentPadding: EdgeInsets.symmetric(horizontal: 30),
                  title: Text(
                    formattedDate,
                    style: Theme.of(context).textTheme.headlineSmall?.copyWith(color: Colors.white),
                  ),
                  
                ),
                const SizedBox(height: 10),
              ListTile(
                contentPadding: EdgeInsets.symmetric(horizontal: 30),
                title: Text('Hi',
                    style: Theme.of(context)
                        .textTheme
                        .headlineSmall
                        ?.copyWith(color: Colors.white)),
                subtitle: Text(
                  'Selamat Datang, $username',
                  style: Theme.of(context)
                      .textTheme
                      .titleMedium
                      ?.copyWith(color: Colors.white),
                ),
              ),
              const SizedBox(
                height: 30,
              ),
            ]),
          ),
          Container(
            child: Container(
              child: GridView.count(
                padding: const EdgeInsets.all(25),
                shrinkWrap: true,
                crossAxisCount: 2,
                crossAxisSpacing: 40,
                mainAxisSpacing: 30,
                children: <Widget>[
                  Card(
                    margin: const EdgeInsets.all(8),
                    child: InkWell(
                      onTap: () {
                        Navigator.push(
                            context,
                            MaterialPageRoute(
                                builder: (context) => LaporanBaru(id_user: id_user,)));
                      },
                      splashColor: Colors.green,
                      child: Center(
                        child: Column(
                          mainAxisSize: MainAxisSize.min,
                          children: <Widget>[
                            Image.asset(
                              "laporan.png",
                              width: 70,
                            ),
                            Text(
                              "Laporan Harian",
                              style: TextStyle(fontSize: 17.0),
                            ),
                          ],
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

}