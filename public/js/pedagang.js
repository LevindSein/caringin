$(document).ready(function(){
	$('#tabelPedagang').DataTable({
		processing: true,
		serverSide: true,
		ajax: {
			url: "/pedagang",
            cache:false,
		},
		columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', class : 'text-center' },
			{ data: 'nama', name: 'nama', class : 'text-center' },
			{ data: 'anggota', name: 'anggota', class : 'text-center' },
			{ data: 'ktp', name: 'ktp', class : 'text-center' },
			{ data: 'email', name: 'email', class : 'text-center' },
			{ data: 'hp', name: 'hp', class : 'text-center' },
			{ data: 'action', name: 'action', class : 'text-center' },
        ],
        stateSave: true,
        scrollX: true,
        deferRender: true,
        pageLength: 8,
        fixedColumns:   {
            "leftColumns": 2,
            "rightColumns": 2,
        },
        aoColumnDefs: [
            { "bSortable": false, "aTargets": [2,3,4,5,6] }, 
            { "bSearchable": false, "aTargets": [6] }
        ],
        order:[[1, 'asc']]
    });

    var id;
    
    $('.alamatPemilik').select2();
    $('.alamatPengguna').select2();

    $('#add_pedagang').click(function(){
		$('.modal-title').text('Tambah Pedagang');
        $('#alamatPemilik').prop('required', false);
        $('#alamatPengguna').prop('required', false);
		$('#action_btn').val('Tambah');
		$('#action').val('Add');
		$('#form_result').html('');
        $('#form_pedagang')[0].reset();
        $('#displayPemilik').hide();
        $('#displayPengguna').hide();
        $('#username').val();
        $('#form_pedagang')[0].reset();

        $('#alamatPemilik').select2("destroy").val('').html('').select2({
            placeholder: '--- Pilih Kepemilikan ---',
            ajax: {
                url: "/cari/alamat",
                dataType: 'json',
                delay: 250,
                processResults: function (alamat) {
                    return {
                    results:  $.map(alamat, function (al) {
                        return {
                        text: al.kd_kontrol,
                        id: al.id
                        }
                    })
                    };
                },
                cache: true,
            }
        });

        $('#alamatPengguna').select2("destroy").val('').html('').select2({
            placeholder: '--- Pilih Tempat ---',
            ajax: {
                url: "/cari/alamat",
                dataType: 'json',
                delay: 250,
                processResults: function (alamat) {
                    return {
                    results:  $.map(alamat, function (al) {
                        return {
                        text: al.kd_kontrol,
                        id: al.id
                        }
                    })
                    };
                },
                cache: true
            }
        });

		$('#myModal').modal('show');
    });
    
    $(document).on('click', '.edit', function(){
		id = $(this).attr('id');
        $('#hidden_id').val(id);
        $('.modal-title').text('Edit Pedagang');
        $('#alamatPemilik').prop('required', false);
        $('#alamatPengguna').prop('required', false);
        $('#action_btn').val('Update');
        $('#action').val('Edit');
		$('#form_result').html('');
        $('#form_pedagang')[0].reset();
        $('#displayPemilik').hide();
        $('#displayPengguna').hide();
        $('#username').val();
        $('#form_pedagang')[0].reset();

        var s1 = $('#alamatPemilik').select2("destroy").val('').html('').select2({
            placeholder: '--- Pilih Kepemilikan ---',
            ajax: {
                url: "/cari/alamat",
                dataType: 'json',
                delay: 250,
                processResults: function (alamat) {
                    return {
                    results:  $.map(alamat, function (al) {
                        return {
                        text: al.kd_kontrol,
                        id: al.id
                        }
                    })
                    };
                },
                cache: true
            }
        });

        var s2 = $('#alamatPengguna').select2("destroy").val('').html('').select2({
            placeholder: '--- Pilih Tempat ---',
            ajax: {
                url: "/cari/alamat",
                dataType: 'json',
                delay: 250,
                processResults: function (alamat) {
                    return {
                    results:  $.map(alamat, function (al) {
                        return {
                        text: al.kd_kontrol,
                        id: al.id
                        }
                    })
                    };
                },
                cache: true
            }
        });

		$.ajax({
			url :"/pedagang/"+id+"/edit",
            cache:false,
			dataType:"json",
			success:function(data)
			{
				$('#ktp').val(data.result.ktp);
                $('#nama').val(data.result.nama);
                $('#username').val(data.result.username);
                $('#anggota').val(data.result.anggota);
                $('#email').val(data.result.email);
                $('#hp').val(data.result.hp);
                $('#alamat').val(data.result.alamat);

                if(data.result.checkPemilik == 'checked'){
                    $("#pemilik").prop("checked", true);
                    $('#alamatPemilik').prop('required', true);
                    $("#displayPemilik").show();

                    var valPemilik = data.result.pemilik;

                    valPemilik.forEach(function(e){
                        if(!s1.find('option:contains(' + e + ')').length) 
                            s1.append($('<option>').text(e));
                    });
                    s1.val(valPemilik).trigger("change"); 
                }
                else{
                    $("#pemilik").prop("checked", false);
                    $("#displayPemilik").hide();
                }
                
                if(data.result.checkPengguna == 'checked'){
                    $("#pengguna").prop("checked", true);
                    $('#alamatPengguna').prop('required', true);
                    $("#displayPengguna").show();

                    var valPengguna = data.result.pengguna;
                    
                    valPengguna.forEach(function(e){
                        if(!s2.find('option:contains(' + e + ')').length) 
                            s2.append($('<option>').text(e));
                    });
                    s2.val(valPengguna).trigger("change"); 
                }
                else{
                    $("#pengguna").prop("checked", false);
                    $("#displayPengguna").hide();
                }
                
                $('#myModal').modal('show');
			}
		})
    });

    $('#form_pedagang').on('submit', function(event){
		event.preventDefault();
		var action_url = '';

		if($('#action').val() == 'Add')
		{
			action_url = "/pedagang";
        }

        if($('#action').val() == 'Edit')
		{
			action_url = "/pedagang/update";
		}

		$.ajax({
			url: action_url,
            cache:false,
			method:"POST",
			data:$(this).serialize(),
			dataType:"json",
			success:function(data)
			{
                $('#form_result').show();
				var html = '';
				if(data.errors)
				{
                    html = '<div class="alert alert-danger" id="error-alert"> <strong>Maaf ! </strong>' + data.errors + '</div>';
                    console.log(data.errors);
				}
				if(data.success)
				{
					html = '<div class="alert alert-success" id="success-alert"> <strong>Sukses ! </strong>' + data.success + '</div>';
                }
                $('#tabelPedagang').DataTable().ajax.reload(function(){}, false);
				$('#form_result').html(html);
                $("#success-alert,#error-alert,#info-alert,#warning-alert")
                    .fadeTo(2000, 1000)
                    .slideUp(2000, function () {
                        $("#success-alert,#error-alert").slideUp(1000);
                });
                $('#myModal').modal('hide');
			}
		});
    });
    
    function evaluate() {
        var item = $(this);
        var relatedItem = $("#" + item.attr("data-related-item")).parent();

        if (item.is(":checked")) {
            relatedItem.fadeIn();
        } else {
            relatedItem.fadeOut();
        }
    }
    $('input[type="checkbox"]')
        .click(evaluate)
        .each(evaluate);
    
    $('#nama').on('input',function(){
        if($('#action').val() == 'Add'){
            nama = $(this).val();
            username = nama.replace(/[^a-zA-Z]/g,'');
            nama = username;
            username = username.slice(0, 7);
            number = Math.floor(1000 + Math.random() * 9000);

            anggota = 'BP3C' + Math.floor(100000 + Math.random() * 982718);
            anggota = anggota.slice(0, 10);

            if(nama == ''){
                document.getElementById("username").value = '';
                document.getElementById("anggota").value = '';
            }
            else{
                document.getElementById("username").value = username + number;
                document.getElementById("anggota").value = anggota;
            }
        }
    });

    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    function shuffle(string) {
        var parts = string.split('');
        for (var i = parts.length; i > 0;) {
            var random = parseInt(Math.random() * i);
            var temp = parts[--i];
            parts[i] = parts[random];
            parts[random] = temp;
        }
        return parts.join('');
    }

    var user_id;
    $(document).on('click', '.delete', function(){
		user_id = $(this).attr('id');
		$('#confirmModal').modal('show');
	});

	$('#ok_button').click(function(){
		$.ajax({
			url:"/pedagang/destroy/"+user_id,
            cache:false,
			beforeSend:function(){
				$('#ok_button').text('Menghapus...');
			},
			success:function(data)
			{
                $('#form_result').hide();
				setTimeout(function(){
                    $('#confirmModal').modal('hide');
					$('#tabelPedagang').DataTable().ajax.reload(function(){}, false);
				}, 4000);
                html = '<div class="alert alert-info" id="info-alert"> <strong>Info! </strong>' + data.status + '</div>';
                $('#confirm_result').html(html);     
                $("#success-alert,#error-alert,#info-alert,#warning-alert")
                    .fadeTo(2000, 1000)
                    .slideUp(2000, function () {
                        $("#success-alert,#error-alert").slideUp(1000);
                });
            },
            complete:function(){
                $('#ok_button').text('Hapus');
            }
        })
    });
    
    function checkPemilik() {
        if ($('#pemilik').is(':checked')) {
            document
                .getElementById('alamatPemilik')
                .required = true;
        } else {
            document
                .getElementById('alamatPemilik')
                .required = false;
        }
    }
    $('input[type="checkbox"]')
        .click(checkPemilik)
        .each(checkPemilik);

    function checkPengguna() {
        if ($('#pengguna').is(':checked')) {
            document
                .getElementById('alamatPengguna')
                .required = true;
        } else {
            document
                .getElementById('alamatPengguna')
                .required = false;
        }
    }
    $('input[type="checkbox"]')
        .click(checkPengguna)
        .each(checkPengguna);

    $('[type=tel]').on('change', function(e) {
        $(e.target).val($(e.target).val().replace(/[^\d\.]/g, ''))
    });

    $('[type=tel]').on('keypress', function(e) {
        keys = ['0','1','2','3','4','5','6','7','8','9']
        return keys.indexOf(e.key) > -1
    });
    
    $("#nama").on("change paste keyup", function(e){
        $(e.target).val($(e.target).val().replace(/[^a-zA-Z.\s]/gi,''));
    });
});