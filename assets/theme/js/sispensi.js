
$('#zbtnModalNotification').click(function() {
    loadModal('NOTIF');
});
$('#menuChangePassword').click(function() {
    loadModal('CHANGEPASS');
});



function loadModal(mode){
    $.ajax({
        url: baseurl+"api/getmodal",
        type: "POST",
        dataType: "json",
        data: { mode:mode },
        success : function(data){
            if(data.status==0){
                $('#dataModal').html(data.htmlmodal);
		        $("#dataModal").find("#dataModalTable").addClass("table table-hover");
            } else{

            }
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

function loadStatus(stscd){
    $.ajax({
        url: baseurl+"ranperda/loadstatus",
        type: "POST",
        dataType: "json",
        data: {stscd:stscd},
        success : function(data){
            $('#txtStatusCd').val(data.stscd);
            $('#txtStatusNm').val(data.stsnm); 
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

function authButton(butmo,curst,nexst,iscls,isrea){
    if(isrea == "X"){
        $('#zmdlReason').modal('show');
        $("#txtReasonCurrst").val(curst);
        $("#txtReasonNextst").val(nexst);
    }
    switch(butmo){
        case 'BTN_BACK_SELECT':
            location.href = '/sispensi/ranperda';
        break;

        case 'BTN_SAVE_DATA':
            saveData(butmo,curst,nexst,iscls,isrea);
        break;

        case 'BTN_REQ_APPV':  
            saveData(butmo,curst,nexst,iscls,isrea);
        break;

        case 'BTN_APPROVED':
            var ask = confirm("Anda Yakin Menerima Ranperda Ini?");  
            if (ask == true){
                saveData(butmo,curst,nexst,iscls,isrea);
            }
        break;

        case 'BTN_DELETE_DATA':
            var ask = confirm("Anda Yakin Menghapus Ranperda Ini?");
            if (ask == true){
                saveData(butmo,curst,nexst,iscls,isrea);
            }
        break;
        

        default:	
        break;
    }
}

function loaddata() {
    var wfnum = $('#txtWfnum').val();

    var formData = {
        'wfnum': wfnum,
    };
    $.ajax({
        url: baseurl+"ranperda/loaddata",
        type: "POST",
        dataType: "json",
        data: formData,
        success : function(data){

            var head = data.header;

            $("#txtSPBupati").val(head.sp_walikota);
            $("#txtSPBupati-prov").val(head.sp_walikota);
            $("#datetglSP1").val(head.sp_walikota_tgl);
            $("#txtKabDesc").val(head.kab_desc);
            $("#txtKabIsiSurat").val(head.kab_isisurat);

            loadItem('KP01',wfnum);

            // Evaluasi
            $("#txtSPGubernur").val(head.sp_gubernur);
            $("#txtSPGubernur-kem").val(head.sp_gubernur);
            $("#datetglSP2").val(head.sp_gubernur_tgl);
            $("#txtProDesc").val(head.pro_desc);
            $("#txtProIsisurat").val(head.pro_isisurat);

            // kepGUb
            $("#txtSPGubernur-prov").val(head.sp_gubernur);
            $("#txtSPSekda").val(head.sp_sekda);
            $("#datetglSP4").val(head.sp_sekda_tgl);
            $("#txtProDescSekda").val(head.pro_descsekda);
            $("#txtProIsiSuratSekda").val(head.pro_isisuratsekda);

            loadItem('PR01',wfnum);
            loadItem('PR02',wfnum);

            $("#txtSpMdn").val(head.sp_mdn);
            $("#datetglSP3").val(head.sp_mdn_tgl);
            $("#txtKemDesc").val(head.kem_desc);
            $("#txtKemIsiSurat").val(head.kem_isisurat);

            loadItem('KM01',wfnum);

            loadItem('KP02',wfnum);
            
            loadStatus(head.curst);
            loadHistory();
            roleScreen(head.curst,''),
            workflow();

            $.each( data.item, function( key, value ) { 
                $('#btn'+value.fcode).html('<button onclick="fdownload('+"'"+value.encrypt_name+"'"+','+"'"+value.original_name+"'"+');" class="btn btn-sm btn-default"><i class="splashy-document_a4_download"></i> '+value.original_name+'</button>');
                //alert( key + ": " + value.wfnum );
            });
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

function fdownload(encrypt,original){
    //alert(encrypt)
    location.href = baseurl+'ranperda/push_file/'+encrypt+'/'+original;
}

function saveData(butmo,curst,nexst,iscls,isrea){

    var data = new FormData();

    data.append('butmo', butmo);
    data.append('curst', curst);
    data.append('nexst', nexst);
    data.append('iscls', iscls);
    data.append('isrea', isrea);
    

    if(nexst.substring(0, 2) == 'RN'){
        data.append('wfnum', $('#txtWfnum').val());
        data.append('txtSPBupati', $('#txtSPBupati').val());
        data.append('datetglSP1', $("#datetglSP1").val()); 
        data.append('txtKabDesc', $("#txtKabDesc").val()); 
        data.append('txtKabIsiSurat', $("#txtKabIsiSurat").val());
        data.append('txtSPGubernur', $("#txtSPGubernur").val());
        data.append('datetglSP2', $("#datetglSP2").val());
        data.append('txtProDesc', $("#txtProDesc").val());
        data.append('txtProIsisurat', $("#txtProIsisurat").val());
        data.append('txtSpMdn', $("#txtSpMdn").val());
        data.append('datetglSP3', $("#datetglSP3").val());
        data.append('txtKemDesc', $("#txtKemDesc").val());
        data.append('txtKemIsiSurat', $("#txtKemIsiSurat").val());
        data.append('txtSPSekda', $("#txtSPSekda").val());
        data.append('datetglSP4', $("#datetglSP4").val());
        data.append('txtProDescSekda', $("#txtProDescSekda").val());
        data.append('txtProIsiSuratSekda', $("#txtProIsiSuratSekda").val());

        data.append('fileFL01', $("#fileFL01")[0].files[0]);
        data.append('fileFL02', $("#fileFL02")[0].files[0]);
        data.append('fileFL03', $("#fileFL03")[0].files[0]);
        data.append('fileFL04', $("#fileFL04")[0].files[0]);
        data.append('fileFL05', $("#fileFL05")[0].files[0]);

    }

    if(nexst.substring(0, 2) == 'PV'){
        data.append('wfnum', $('#txtWfnum').val());
        data.append('txtSPBupati', $('#txtSPBupati').val());
        data.append('datetglSP1', $("#datetglSP1").val()); 
        data.append('txtKabDesc', $("#txtKabDesc").val()); 
        data.append('txtKabIsiSurat', $("#txtKabIsiSurat").val());
        data.append('txtSPGubernur', $("#txtSPGubernur").val());
        data.append('datetglSP2', $("#datetglSP2").val());
        data.append('txtProDesc', $("#txtProDesc").val());
        data.append('txtProIsisurat', $("#txtProIsisurat").val());
        data.append('txtSpMdn', $("#txtSpMdn").val());
        data.append('datetglSP3', $("#datetglSP3").val());
        data.append('txtKemDesc', $("#txtKemDesc").val());
        data.append('txtKemIsiSurat', $("#txtKemIsiSurat").val());
        data.append('txtSPSekda', $("#txtSPSekda").val());
        data.append('datetglSP4', $("#datetglSP4").val());
        data.append('txtProDescSekda', $("#txtProDescSekda").val());
        data.append('txtProIsiSuratSekda', $("#txtProIsiSuratSekda").val());

        data.append('fileFL01', $("#fileFL01")[0].files[0]);
        data.append('fileFL02', $("#fileFL02")[0].files[0]);
        data.append('fileFL04', $("#fileFL04")[0].files[0]);
        // data.append('fileFL05', $("#fileFL05")[0].files[0]);
    }

    $("#txtTentang").prop('required',true);
    
    $.ajax({
        url: baseurl+"ranperda/saveData",
        type: 'POST', 
        data: data, 
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function(e) {
            $('.page-loader').show();
            if(e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(data){
           $('.page-loader').hide();

            if(data.status==0){
                $("#txtWfnum").val(data.wfnum);
                $('#fileSuratPengantar').val(null); 
                $('#fileKesepakatanDPRD').val(null); 
                $('#fileRancanganPerda').val(null);     
                $('#fileSuratKetGub').val(null); 
                $('#fileMatrikEvaluasi').val(null); 
                $('#fileSuratHasilKonsul').val(null); 
                $('#fileKepGubEvaluasi').val(null); 
                $('#filePerda').val(null); 
                loaddata();
                document.getElementById('ztxtAppsMsg').innerHTML = '';
            }else{
                document.getElementById('ztxtAppsMsg').innerHTML = data.notif;
            }			
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

//function validation

function rejectData(){

    var data = new FormData();

    data.append('wfnum', $('#txtWfnum').val());
    data.append('curre', $('#txtReasonCurrst').val());
    data.append('nexst', $('#txtReasonNextst').val());
    data.append('reasn', $('#txtReason').val());
    
    $.ajax({
        url: baseurl+"ranperda/rejectData",
        type: 'POST', 
        data: data, 
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function(e) {
            // $('#zdivOverlay').show();
            if(e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(data){
            // $('#zdivOverlay').hide();
            $("#txtWfnum").val(data.wfnum);
            $('#fileSuratPengantar').val(null); 
            $('#fileKesepakatanDPRD').val(null); 
            $('#fileRancanganPerda').val(null); 
            loaddata();
            //document.getElementById('ztxtAppsMsg').innerHTML = data.message;			
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}


function workflow(){
    var formData = {
        'wfnum': $('#txtWfnum').val(),
    };
    $.ajax({
        url: baseurl+"ranperda/workflow",
        type: "POST",
        dataType: "json",
        data: formData,
        success : function(data){
            $("#zbtnAction").html('');
            $("#zbtnAction").html(data.button); 
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}


function loadHistory() {

    // hapus datatable
    var table = $('#tblHistory').DataTable();
    table.destroy();

    var formData = {
        'wfnum': $('#txtWfnum').val(),
    };

    $('#tblHistory').DataTable({
        "ajax": {
            "url": baseurl+"ranperda/loadHistory",
            "type": "POST",
            "deferLoading": 57,
            "data": formData,
            "dataSrc": ""
        },
        "columns": [
            { "data": "zdate" },
            { "data": "ztime" },
            { "data": "zuser" },
            { "data": "from_status" },
            { "data": "to_status" },
            { "data": "reason" }
        ]
    });
}

function jenisStatus(){
    var formData = {
        'mode': "JENISSTATUS",
    };
    $.ajax({
        url: baseurl+"ranperda/loadDropdown",
        type: "POST",
        dataType: "json",
        data: formData,
        beforeSend: function(e) {
        },
        success : function(data){
            $('#slcJenisStatus option').remove();
            $('#slcJenisStatus').append(data.option);
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

function roleScreen(curst,nexst){
    // RNA1	New Ranperda
    // RNB1	Ranperda Saved
    // RNBX	Ranperda Saved (Reject By Provinsi)
    // RNC1	Ranperda Request Approval Provinsi
    // RND1	Ranperda Approved Provinsi
    // RNE1	Ranperda Saved Provinsi
    // RNEX	Ranperda Saved (Reject By Kemendagri)
    // RNF1	Ranperda Request Approval Kemendagri
    // RNG1	Kemendagri Approved (Verifikasi Konsultasi)
    // RNH1	Provinsi (Evaluasi Ranperda)
    // RNI1	Pembuatan File Perda
    // RNJ1	Evaluasi Perda
    // RNK1	Perda Diterima Provinsi
    // RNKX	Sanksi Administrasi
    if(curst.substring(0, 2) == 'RN'){

        if(curst=='RNA1' || curst=='RNB1' || curst=='RNBX'){
            $('#tabkab').show();
            $('#tabpro, #tabkem, #divtxtRegNo, #divtxtPerdaNo, #divfileKepGubEvaluasi, #divfilePerda, #accUploadPerda').hide();
        }

        if(curst=='RNC1'){
            $('#tabkab').show();
            $('#tabpro, #tabkem, #divtxtRegNo, #divtxtPerdaNo, #divfileKepGubEvaluasi, #divfilePerda, #accUploadPerda').hide();
            $('#tab1 *').attr('disabled', true);
        }

        if(curst=='RND1' || curst=='RNE1' || curst=='RNEX'){
            $('#tabkab, #tabpro').show();
            $('#tabkem, #divtxtRegNo, #divtxtPerdaNo, #divfileKepGubEvaluasi, #divfilePerda, #accUploadPerda, #accKepGub').hide();
            $('#tab1 *').attr('disabled', true);

            $('#tabkab, #tab1').removeClass('active');
            $('#tabpro, #tab2').addClass('active');
        }

        if(curst=='RNF1'){
            $('#tabkab, #tabpro').show();
            $('#tabkem, #divtxtRegNo, #divtxtPerdaNo, #divfileKepGubEvaluasi, #divfilePerda, #accUploadPerda, #accKepGub').hide();
            $('#tab1 *').attr('disabled', true);
            $('#tab2 *').attr('disabled', true);

            $('#tabkab, #tab1').removeClass('active');
            $('#tabpro, #tab2').addClass('active');
        }

        if(curst=='RNG1'){
            $('#tabkab, #tabpro, #tabkem').show();
            $('#divtxtRegNo, #divtxtPerdaNo, #divfileKepGubEvaluasi, #divfilePerda, #accUploadPerda, #accKepGub').hide();
            
            $('#tab1 *').attr('disabled', true);
            $('#tab2 *').attr('disabled', true);

            $('#tabkab, #tabpro, #tab1, #tab2').removeClass('active');
            $('#tabkem, #tab3').addClass('active');
        }

        if(curst=='RNH1'){
            $('#tabkab, #tabpro, #tabkem, #divfileKepGubEvaluasi').show();
            $('#divtxtRegNo, #divtxtPerdaNo, #divfilePerda, #accUploadPerda').hide();
            
            $('#tab1 *').attr('disabled', true);
            $('#accEvaluasi *').attr('disabled', true); // tab 2
            $('#tab3 *').attr('disabled', true);     

            $('#collapsepro1').collapse("hide");
            $('#collapsepro2').collapse("show");
            

            $('#tabkab, #tabkem, #tab1, #tab3').removeClass('active');
            $('#tabpro, #tab2').addClass('active');
        }

        if(curst=='RNI1' || curst=='RNIX'){
            $('#tabkab, #tabpro, #tabkem, #divtxtRegNo, #divtxtPerdaNo, #divfilePerda').show();
            $('#slcJenisPR, #slcJenisPRnm, #txtTentang, #fileSuratPengantar, #fileKesepakatanDPRD, #fileRancanganPerda').attr('disabled', true); // tab 1
            $('#accRancanganPerda *').attr('disabled', true);
            $('#tab2 *').attr('disabled', true);
            $('#tab3 *').attr('disabled', true);
            
            $('#collapsekab1').collapse("hide");
            $('#collapsekab2').collapse("show");

            $('#collapsepro1').collapse("show");
            $('#collapsepro2').collapse("show");

            $('#tabpro, #tabkem, #tab2, #tab3').removeClass('active');
            $('#tabkab, #tab1').addClass('active');
        }

        if(curst=='RNJ1' || curst=='RNK1' || curst=='RNKX'){
            $('#tab1 *').show();
            $('#tab2 *').show();
            $('#tab3 *').show();

            $('#tab1 *').attr('disabled', true);
            $('#tab2 *').attr('disabled', true);
            $('#tab3 *').attr('disabled', true);
            
            $('#collapsekab1, #collapsekab2').collapse("show");
            $('#collapsepro1, #collapsepro2').collapse("show");

            $('#tabpro, #tabkem, #tab2, #tab3').removeClass('active');
            $('#tabkab, #tab1').addClass('active');
        }

        if(curst=='RNXX'){
            $('#tab1 *').attr('disabled', true);
            $('#tab2 *').attr('disabled', true);
            $('#tab3 *').attr('disabled', true);
        }
    }

    // 15	WF02	PVA1	New Ranperda	PVA1
    // 16	WF02	PVB1	Ranperda Saved	PVA1
    // 17	WF02	PVBX	Ranperda Saved (Reject By Kemendagri)	PVC1
    // 18	WF02	PVC1	Ranperda Request Approval Kemendagri	PVC1
    // 19	WF02	PVD1	Kemendagri Approved (Evaluasi Ranperda)	PVD1
    // 20	WF02	PVE1	Kirim Hasil Kepmen Evaluasi	PVE1
    // 21	WF02	PVF1	Request Approval File Perda	PVF1
    // 22	WF02	PVG1	Perda Diterima Kemendagri	PVF1
    // 23	WF02	PVEX	Sanksi Administrasi	PVEX
    if(curst.substring(0, 2) == 'PV'){

        if(curst=='PVA1' || curst=='PVB1' || curst=='PVBX'){
            $('#tabpro').show();
            $('#tabkem, #accUploadPerda').hide();
        }

        if(curst=='PVC1'){
            $('#tabpro').show();
            $('#tabkem, #accUploadPerda').hide();
            $('#tab1 *').attr('disabled', true);
        }

        if(curst=='PVD1'){
            $('#tabpro, #tabkem').show();
            $('#divtxtRegNo, #divtxtPerdaNo, #divfileKepGubEvaluasi, #divfilePerda, #accUploadPerda').hide();
            $('#tab1 *').attr('disabled', true);

            $('#tabpro, #tab1').removeClass('active');
            $('#tabkem, #tab2').addClass('active');
        }

        if(curst=='PVE1' || curst=='PVEX'){
            $('#tabpro, #tabkem').show();
            $('#divtxtRegNo, #divtxtPerdaNo, #divfileKepGubEvaluasi, #divfilePerda').show();
            $('#slcJenisPR, #slcJenisPRnm, #txtTentang, #fileSuratPengantar, #fileKesepakatanDPRD, #fileRancanganPerda').attr('disabled', true);
            $('#accRancanganPerda *').attr('disabled', true);
            $('#accUploadPerda *').attr('disabled', false);
            $('#tab2 *').attr('disabled', true);
            

            $('#tabkem, #tab2').removeClass('active');
            $('#tabpro, #tab1').addClass('active');
        }

        
        if(curst=='PVF1' || curst=='PVG1'){
            $('#tabpro, #tabkem').show();
            $('#tab1 *').attr('disabled', true);
            $('#tab2 *').attr('disabled', true);
        }

        if(curst=='PVXX'){
            $('#tab1 *').attr('disabled', true);
            $('#tab2 *').attr('disabled', true);
        }
    }

}

function userprofile(mode) {

    // hapus datatable
    var table = $('#tblListUsers').DataTable();
    table.destroy();

    var formData = {
        'mode': mode,
    };

    if(mode == 'KAB'){
        var cols = [
            { "data": "usrcd" },
            { "data": "daerah" },
            { "data": "nama_lengkap" },
            { "data": "username" },
            { "data": "jabatan" },
            { "data": "email" },
            { "data": "telepon" },
            { "data": "status" }
        ];
    }

    if(mode == 'PUSAT'){
        var cols = [
            { "data": "usrcd" },
            { "data": "nama_lengkap" },
            { "data": "username" },
            { "data": "jabatan" },
            { "data": "email" },
            { "data": "telepon" },
            { "data": "status" }
        ];
    }    

    $('#tblListUsers').DataTable({
        "ajax": {
            "url": baseurl+"profile/loadAllUsers",
            "type": "POST",
            "deferLoading": 57,
            "data": formData,
            "scrollY": "200px",
            "scrollCollapse": true,
            "paging": false,
            "dataSrc": ""
        },
        "columns": cols
    });

    $('#tblListUsers tbody').on('click', 'tr', function () {
        var table = $('#tblListUsers').DataTable();
        var data = table.row( this ).data();
        //alert( 'You clicked on '+data["wfcat"]+'\'s row' );
        if(data["group_user"] == 0){
            location.href = baseurl+'profile/detail/pusat/'+data["usrcd"];
        }else{
            location.href = baseurl+'profile/detail/kabkot/'+data["usrcd"];
        }
        
    });
}

function loadDetailUsers(){
    var formData = {
        'txtusrcd': $('#txtusrcd').val(),
    };
    $.ajax({
        url: baseurl+"profile/getDataUsers",
        type: "POST",
        dataType: "json",
        data: formData,
        success : function(data){

            $('#txtDaerah').val(data.daerah);
            $("#txtNamaLengkap").val(data.nama_lengkap);
            $("#txtUsername").val(data.username);
            $("#txtJabatan").val(data.jabatan);
            $("#txtEmail").val(data.email);
            $("#txtTlpNo").val(data.telepon);
            $("#txtFaxNo").val(data.fax);
            $("#slcIsActive").val(data.status);
            $("#slcIsSuperAdmin").val(data.superadmin);

        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

function slckabkot(){
    var formData = {
        'kodeprov': $("#slcDaerahProv").val(),
    };
    $.ajax({
        url: baseurl+"ranperda/slckabkot",
        type: "POST",
        dataType: "json",
        data: formData,
        beforeSend: function(e) {
        },
        success : function(data){
            $('#slcDaerahKab option').remove();
            $('#slcDaerahKab').append(data.option);
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

function getCodeNOS(type,size) {
    var text = "";
    var possible = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  
    for (var i = 0; i < size; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));
  
    return type+text;
}

function getCodeNDI(){
    $.ajax({
        url: baseurl+"ranperda/getndi",
        type: 'POST', 
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(data){
            if(data.status == 0){
                $('#txtWfnum').val(data.ndi);
            }else{
                $('#txtWfnum').val('');
            }
        }
    });
}

function addItem(filety,filecd,title,fileid){

    var data = new FormData();

    data.append('wfnum', $('#txtWfnum').val());
    data.append('filety', filety);
    data.append('filecd', filecd);
    data.append('title', $('#'+title).val());
    data.append('filenm', fileid); 
    data.append('fileid', $('#'+fileid)[0].files[0]); 

    data.append('kepgubno', $('#txtKepGubNo').val());
    data.append('kepgubtgl', $('#datetglSP6').val());

    data.append('perdareg', $('#txtRegNo').val());
    data.append('perdano', $('#txtPerdaNo').val());
    data.append('perdatgl', $('#datetglSP7').val());

    if($('#'+title).val() == ''){
        $('#'+title).focus();
        return;
    }

    
    $.ajax({
        url: baseurl+"ranperda/additem",
        type: 'POST', 
        data: data, 
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function(e) {
            $('.page-loader').show();
        },
        success: function(data){
            $('.page-loader').hide();

            $('#fileRancanganPerda, #txtDescFiles').val('');
            $('#fileRancanganPerdaPR01, #txtDescFilesPR01').val('');
            $('#fileRancanganPerdaKM01, #txtDescFilesKM01').val('');
            $('#fileRancanganPerdaPR02, #txtDescFilesPR02, #datetglSP6, #txtKepGubNo').val('');
            $('#fileRancanganPerdaKP02, #txtDescFilesKP02, #datetglSP7, #txtRegNo, #txtPerdaNo').val('');
            if(data.status == 0){
                loadItem(filety,$('#txtWfnum').val());
                document.getElementById('ztxtAppsMsg').innerHTML = '';
            }else{
                document.getElementById('ztxtAppsMsg').innerHTML = data.notif;
            }		
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

function loadItem(filety,wfnum){

    var data = new FormData();

    data.append('wfnum', wfnum);
    data.append('filety', filety);


    $.ajax({
        url: baseurl+"ranperda/loaditem",
        type: 'POST', 
        data: data, 
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function(e) {
            $('.page-loader').show();
            if(e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(data){
           $('.page-loader').hide();
            $('#tbl'+filety).html(data.html);			
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

function delItem(filety,wfnum,filecd){

    var data = new FormData();

    data.append('wfnum', wfnum);
    data.append('filety', filety);
    data.append('filecd', filecd);


    $.ajax({
        url: baseurl+"ranperda/delitem",
        type: 'POST', 
        data: data, 
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function(e) {
            $('.page-loader').show();
        },
        success: function(data){
           $('.page-loader').hide();
           loadItem(filety,wfnum);		
        }
    });
}
