function sepet_bilgisi() {
  $.ajax({
    url: "../eticaret/kutuphane/sepet_bilgisi.php",
    method: "POST",
    success: function (data)
    {
      $('#sepet-bilgi').html(data);
    }
  });
}

function sepet_ekle(urun_id) {
  $.ajax({
    type: "POST",
    url: "../eticaret/kutuphane/sepet_ekle.php",
    data: {
      urun_id: urun_id
    },
    success: function (sonuc) {
      $('#modal-container').html(sonuc);
      $('#sepet-modal').modal('show');
    },
    error: function (sonuc) {
      $('#modal-container').html(sonuc);
      $('#sepet-modal').modal('show');
    }
  });
  sepet_bilgisi();
}

function sepetAdetAzalt(id, urun_fiyat) {
  var urunAdetEleman = $("#sepet_" + id + "_adet");
  var urunAdet = parseInt($(urunAdetEleman).val());
  if (urunAdet > 1) {
    var yeniAdet = urunAdet - 1;
    var yeniUrunToplamFiyat = yeniAdet * urun_fiyat;
    sepet_urun_guncelle(id, yeniAdet, yeniUrunToplamFiyat);
  }
}

function sepetAdetCogalt(id, urun_fiyat) {
  var urunAdetEleman = $("#sepet_" + id + "_adet");
  var urunAdet = parseInt($(urunAdetEleman).val());
  var yeniAdet = urunAdet + 1;
  var yeniUrunToplamFiyat = yeniAdet * urun_fiyat;
  sepet_urun_guncelle(id, yeniAdet, yeniUrunToplamFiyat);
}

function sepet_urun_guncelle(id, yeni_adet, yeni_fiyat) {
  var urunAdetEleman = $("#sepet_" + id + "_adet");
  var urunToplamFiyatEleman = $("#sepet_" + id + "_toplam_fiyat");
  var sepetToplamFiyatEleman = $("#sepetToplamFiyat");
  $.ajax({
    url: "../eticaret/kutuphane/sepet_guncelle.php",
    data: "id=" + id + "&urun_yeni_adet=" + yeni_adet,
    type: 'post',
    success: function (sepetToplamFiyat) {
      $(urunAdetEleman).val(yeni_adet);
      $(urunToplamFiyatEleman).text(yeni_fiyat);
      $(sepetToplamFiyatEleman).text(sepetToplamFiyat);
      sepet_bilgisi();
    }
  });
}

$(document).ready(function () {
  sepet_bilgisi();

  $(document).on('click', '.list-down-btn', function (event) {
    event.preventDefault();
    var target = $(this).attr('data-toggle');
    $(target).slideToggle();
    var clicked = event.target;
    $(clicked).toggleClass("fa-chevron-down fa-chevron-up");
  });

  $('#modal-sil').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var link = button.data("href");
    var modal = $(this);
    modal.find(".modal-footer a").attr("href", link);
  });

  $('#modal-temizle').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var link = button.data("href");
    var modal = $(this);
    modal.find(".modal-footer a").attr("href", link);
  });


});