

function resim_upload_pp_ayarlar(){
  var ppupinput = document.getElementsByClassName("ppupinput");
  var ppupbuton = document.getElementsByClassName("ppupbuton");
  var uploadpp = document.getElementsByClassName("uploadpp");
  var uploadi = document.getElementsByClassName("fas fa-upload");

  if(uploadpp[0].style.display == "none"){
    ppupinput[0].style.display = "none";
    ppupbuton[0].style.display = "none";
    uploadi[0].style.display = "none";
    uploadpp[0].style.display  = "block";
  }
}

function resim_upload_kp_ayarlar(){
  var kpupinput = document.getElementsByClassName("kpupinput");
  var kpupbuton = document.getElementsByClassName("kpupbuton");
  var kpload = document.getElementsByClassName("uploadkp");
  var uploadi = document.getElementsByClassName("fas fa-upload");

  if(kpload[0].style.display == "none"){
    kpupinput[0].style.display = "none";
    kpupbuton[0].style.display = "none";
    uploadi[1].style.display = "none";
    kpload[0].style.display  = "block";
  }
}


function resim_upload(){
  var yukle_durum = document.getElementById("cevap_resim_yukle");
  var upload_gorsel = document.getElementById("upload_gorsel");
  var gizle_goster_text_input = document.getElementsByClassName("anket_olustur_cevap_resim");
  var file_input = document.getElementsByClassName("img_file_input");
  var x = localStorage.getItem("sayi");
  


  if (yukle_durum.value === "0"){
      yukle_durum.value = "1";
      upload_gorsel.className = "fa fa-link";
      gizle_goster_text_input[0].style.display = "none";
      gizle_goster_text_input[1].style.display = "none";
      gizle_goster_text_input[2].style.display = "none";
      gizle_goster_text_input[3].style.display = "none";
      gizle_goster_text_input[4].style.display = "none";

      if (x == null){
        localStorage.setItem("sayi", "0");
        file_input[0].style.display = "block";
        file_input[1].style.display = "block";
      }

      if(x === "0" ||x === "1" ||x === "2" || x === "-1"){
        file_input[0].style.display = "block";
        file_input[1].style.display = "block";
        }
        if(x === "1" || x=== "2" || x === "-1"){
          file_input[2].style.display = "block"; 
        }

        if(x === "2" || x === "-1"){
          file_input[3].style.display = "block"; 
        }

        if(x === "-1"){
          file_input[4].style.display = "block";
        }

  }else{

    if (x == null){
      localStorage.setItem("sayi", "0");
      gizle_goster_text_input[0].style.display = "block";
      gizle_goster_text_input[1].style.display = "block";
    }

      yukle_durum.value = "0";
      upload_gorsel.className = "fa fa-upload";

      if(x === "0" || x === "-1" ||x === "1" ||x === "2"){
      gizle_goster_text_input[0].style.display = "block";
      gizle_goster_text_input[1].style.display = "block";
      }
      if(x === "1" || x=== "2" || x === "-1"){
        gizle_goster_text_input[2].style.display = "block"; 
      }
      if(x === "2" || x === "-1"){
        gizle_goster_text_input[3].style.display = "block"; 
      }
      if(x === "-1"){
        gizle_goster_text_input[4].style.display = "block";
      }
    

      file_input[0].style.display = "none";
      file_input[1].style.display = "none";
      file_input[2].style.display = "none";
      file_input[3].style.display = "none";
      file_input[4].style.display = "none";
  }
}


function aramayap(){
  var x = document.getElementById("aranankelime");
  window.location.href='/ara/'+x.value;

}

function ara_ac_kapa(){
  var ara_ac_kapat = document.getElementsByClassName("ara_goster");
  if(ara_ac_kapat[0].style.display == "none"){
    ara_ac_kapat[0].style.display = "block";
  }else{
    ara_ac_kapat[0].style.display = "none";
  }
}


function bildirim_goster(){
  var bildirim_div = document.getElementsByClassName("bildirimler_goster");
  var bildirim_ac_kapa = document.getElementById("bildirim_ac_kapa");
  
  if(bildirim_ac_kapa.className == "fas fa-bell-slash" || bildirim_ac_kapa.className == "fas fa-bell"){

    if(bildirim_div[0].style.display == "none"){
      bildirim_div[0].style.display = "block";
      bildirim_ac_kapa.className = "fas fa-bell-slash";
    }else{
      bildirim_div[0].style.display = "none";
      bildirim_ac_kapa.className = "fas fa-bell";
    }

  }else{
    if(bildirim_div[0].style.display == "none"){
      bildirim_div[0].style.display = "block";
      bildirim_ac_kapa.className = "far fa-bell-slash";
    }else{
      bildirim_div[0].style.display = "none";
      bildirim_ac_kapa.className = "far fa-bell";
    }
  }
  
}

function cevap_video_yap(){
    var cevap_video_yap = document.getElementsByClassName('anket_olustur_cevap_resim');
    var video_yap = document.getElementById('cevap_video_yap');
    var video_yap_int = document.getElementById('cevap_video_yap_int');


      if (video_yap_int.value === "0") {
        for (var i = 0; i < cevap_video_yap.length; i++) {
         cevap_video_yap[i].placeholder = "Video URL (Youtube)";
        }

        video_yap.className = "fa fa-image";
        video_yap_int.value = "1";
      }else if (video_yap_int.value === "1") {
        for (var i = 0; i < cevap_video_yap.length; i++) {
         cevap_video_yap[i].placeholder = "Cevap Resim URL";
        }

        video_yap.className = "fa fa-video";
        video_yap_int.value = "0";

      }


}

function cevap_secenek_ekle (){
  var c = document.getElementsByClassName("anket_olustur_cevap");
  var x = localStorage.getItem("sayi");
  var y = document.getElementsByClassName("anket_olustur_cevap_resim");
  var t = document.getElementById("cevap_secenek_ekle_cikart");
  var yukle_durum = document.getElementById("cevap_resim_yukle");
  var file_input = document.getElementsByClassName("img_file_input");

  if (yukle_durum.value === "0"){
  if (x == null){
      localStorage.setItem("sayi", "0");
  }

  var i = -1;
  while (i < x) {
    i++;
    var y_yeni = Number("2") + Number(i);
    var yeni_sayi = Number(x) + Number("1");
    c[i].style.display = "block";
    y[y_yeni].style.display = "block";
    localStorage.setItem("sayi", yeni_sayi);
    if (i == 2) {
        localStorage.setItem("sayi", "-1");
        i = -1;
        t.className = "fa fa-minus";
        return;
    }
  }
if (x == -1) {
  for (var i = 0; i < c.length; i++) {
    c[i].style.display = "none";
  }
  for (var i = 2; i < y.length; i++) {
    y[i].style.display = "none";
  }
    localStorage.setItem("sayi", "0");
    t.className = "fa fa-plus";

}

}else{

  if (x == null){
    localStorage.setItem("sayi", "0");
}

var i = -1;
while (i < x) {
  i++;
  var y_yeni = Number("2") + Number(i);
  var yeni_sayi = Number(x) + Number("1");
  c[i].style.display = "block";
  file_input[y_yeni].style.display = "block";
  localStorage.setItem("sayi", yeni_sayi);
  if (i == 2) {
      localStorage.setItem("sayi", "-1");
      i = -1;
      t.className = "fa fa-minus";
      return;
  }
}
if (x == -1) {
for (var i = 0; i < c.length; i++) {
  c[i].style.display = "none";
}
for (var i = 2; i < file_input.length; i++) {
  file_input[i].style.display = "none";
}
  localStorage.setItem("sayi", "0");
  t.className = "fa fa-plus";

}


}
}

function anket_olustur_genislet(){
  var x = document.getElementById("anket_olustur");
  if (x.style.height < "50px") {
    x.style.height = "auto";
  }else{
    x.style.height = "43.2px";
  }
}
