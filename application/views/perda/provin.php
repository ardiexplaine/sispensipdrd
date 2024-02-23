<script type="text/javascript" class="init">
    $(document).ready(function() {

        var wfnum = $('#txtWfnum').val();
        if(wfnum != ''){
            loaddata();
        }else{
            workflow();
            getCodeNDI();
            loadStatus('PVA1');
            roleScreen('PVA1','');
        }

        $('#btnReason').on('click', function() {
            $('#zmdlReason').modal('hide');
            rejectData();
        });

        $('#BTN_ADDITEM_KAB01').on('click', function() {
            addItem('KP01',getCodeNOS('IT',7),'txtDescFiles','fileRancanganPerda');
        });
        $('#BTN_ADDITEM_PRO01').on('click', function() {
            addItem('PR01',getCodeNOS('IT',7),'txtDescFilesPR01','fileRancanganPerdaPR01');
        });
        $('#BTN_ADDITEM_KEM01').on('click', function() {
            addItem('KM01',getCodeNOS('IT',7),'txtDescFilesKM01','fileRancanganPerdaKM01');
        });
        $('#BTN_ADDITEM_PRO02').on('click', function() {
            addItem('PR02',getCodeNOS('IT',7),'txtDescFilesPR02','fileRancanganPerdaPR02');
        });
        $('#BTN_ADDITEM_KAB02').on('click', function() {
            addItem('KP02',getCodeNOS('IT',7),'txtDescFilesKP02','fileRancanganPerdaKP02');
        });
        
        // kabkota
        $('#file_surat_ke_gubernur').on("change", function(){ doUploads('file_surat_ke_gubernur', ["pdf"]); });
        $('#file_surat_ke_mendagri').on("change", function(){ doUploads('file_surat_ke_mendagri', ["pdf"]); });
        $('#file_surat_ke_menkeu').on("change", function(){ doUploads('file_surat_ke_menkeu', ["pdf"]); });
        $('#file_ltr_blkng').on("change", function(){ doUploads('file_ltr_blkng', ["pdf"]); });
        $('#file_berita_acara').on("change", function(){ doUploads('file_berita_acara', ["pdf"]); });
        $('#file_ranperda').on("change", function(){ doUploads('file_ranperda', ["doc", "docx"]); });
        $('#file_lampiran_ranperda').on("change", function(){ doUploads('file_lampiran_ranperda', ["doc", "docx"]); });
        $('#file_draft_matrik_ranperda').on("change", function(){ doUploads('file_draft_matrik_ranperda', ["doc", "docx"]); });
        $('#file_revisi_ranperda').on("change", function(){ doUploads('file_revisi_ranperda', ["doc", "docx"]); });
        $('#file_revisi_lampiran_ranperda').on("change", function(){ doUploads('file_revisi_lampiran_ranperda', ["doc", "docx"]); });
        

        // Provinsi
        $('#file_surat_gub_ke_kabkota').on("change", function(){ doUploads('file_surat_gub_ke_kabkota', ["pdf"]); });
        $('#file_kepgub').on("change", function(){ doUploads('file_kepgub', ["pdf"]); });
        $('#file_ttd_matrik_ev_provinsi').on("change", function(){ doUploads('file_ttd_matrik_ev_provinsi', ["pdf"]); });
        $('#file_edited_matrik_ev_provinsi').on("change", function(){ doUploads('file_edited_matrik_ev_provinsi', ["doc", "docx"]); });

        // kemenkeu
        $('#file_surat_menkeu_ke_mendagri').on("change", function(){ doUploads('file_surat_menkeu_ke_mendagri', ["pdf"]); });

        // Mendagri
        $('#file_surat_mendagri_kegub').on("change", function(){ doUploads('file_surat_mendagri_kegub', ["pdf"]); });
        $('#file_kepmendagri').on("change", function(){ doUploads('file_kepmendagri', ["pdf"]); });
        $('#file_ttd_matrik_ev_mendagri').on("change", function(){ doUploads('file_ttd_matrik_ev_mendagri', ["pdf"]); });
        $('#file_edited_matrik_ev_mendagri').on("change", function(){ doUploads('file_edited_matrik_ev_mendagri', ["doc", "docx"]); });
        


        

        // datepicker
        datepic('tgl_surat_ke_gubernur','yyyy-mm-dd');
        datepic('tgl_surat_ke_mendagri','yyyy-mm-dd');
        datepic('tgl_surat_ke_menkeu','yyyy-mm-dd');
        datepic('tgl_surat_gub_ke_kabkota','yyyy-mm-dd');
        datepic('tgl_kepgub','yyyy-mm-dd');
        datepic('tgl_surat_mendagri_kegub','yyyy-mm-dd');
        datepic('tgl_kepmendagri','yyyy-mm-dd');
        datepic('datetglSP7','yyyy-mm-dd');
        
        
        
        

        

        // $('#jns_pad').on('change', function() {
        //     funcSelectAttr('PAD','','jns_pajak',$(this).val());
        // });

        $('#hasil_evaluasi').on('change', function() {
            hasilEvaluasi('WF02',$(this).val());
        });

        

    });
</script>
<h3 class="heading"><strong>RANPERDA > <i>PROVINSI </i>  <i id="redLabel"></i></strong>
    <div class="pull-right" id="lblStatus">
</h3>

<div class="row">
    <div class="col-sm-9 col-md-9">
        <div id="zbtnAction" class="form-actions"></div>
    </div>
    <div class="col-sm-3 col-md-3">
        <div id="ztxtAppsMsg" class="AppsMsg"></div>
    </div>
</div>

<div class="row" id="tabHeader">
    <div class="col-sm-10 col-md-10">
        <table style="width:60%">
            <tr>
                <td style="width:30%"><h4>No. Dokumen Input (NDI)</h4></td>
                <td style="width:70%">
                    <input type="text" class="input-sm form-control" id="txtWfnum" readonly="readonly" value="<?php echo isset($wfnum) ? $wfnum : ''; ?>">
                    <input type="hidden" id="txtStatusCd" readonly="readonly">
                </td>
            </tr>
            <tr>
                <td><h4>Kategori Permohonan</h4></td>
                <td>
                    <select  class="input-sm form-control" name="kategori" id="kategori">
                        <option value=""></option>
                        <?php 
                            $query = $this->db->get_where('attr',array('slctype'=>'KTR'));
                            foreach($query->result() as $row) :
                        ?>
                        <option value="<?php echo $row->code;?>"><?php echo $row->description;?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <!-- <tr>
                <td><h4>Kelompok PAD</h4></td>
                <td>
                    <select  class="input-sm form-control" name="jns_pad" id="jns_pad" >
                        <option value=""></option>
                        <?php 
                            $query = $this->db->get_where('attr',array('slctype'=>'PAD'));
                            foreach($query->result() as $row) :
                        ?>
                        <option value="<?php echo $row->code;?>"><?php echo $row->description;?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><h4>Jenis PDRD</h4></td>
                <td>
                    <select  class="input-sm form-control" name="jns_pajak" id="jns_pajak"></select>
                </td>
            </tr> -->

            <?php echo $this->Global_model->listCheckList('Kelompok PAD',1,$ischecked); ?>
            <?php echo $this->Global_model->listCheckList('Jenis Pajak',3,$ischecked); ?>
            <?php echo $this->Global_model->listCheckList('Jenis Retribusi Jasa Umum',4,$ischecked); ?>
            <?php echo $this->Global_model->listCheckList('Jenis Retribusi Jasa Usaha',5,$ischecked); ?>
            <?php echo $this->Global_model->listCheckList('Jenis Retribusi Perizinan Tertentu',6,$ischecked); ?>

        </table> 
    </div>	
</div>

<div class="row" id="tabBody">
    <div class="col-sm-12 col-md-12">
        <div class="tabbable tabbable-bordered">
            <ul class="nav nav-tabs">
                <li id="tabkab" class="active"><a href="#tab1" data-toggle="tab">Provinsi</a></li>
                <li id="tabpro"><a href="#tab2" data-toggle="tab">Kemendagri</a></li>
                <li id="tabhistory"><a href="#tab5" data-toggle="tab">Riwayat</a></li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane active" id="tab1">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-horizontal" role="form">
                                
                                <div class="panel-group" id="accordion">

                                    <div id="accRancanganPerda" class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapsekab1">Penyampaian Rancangan Perda atau Perubahan Perda Kab/Kota</a>
                                            </h4>
                                        </div>
                                        <div id="collapsekab1" class="panel-collapse collapse in">
                                            <div class="panel-body">

                                                <h4>Surat Permohonan</h4><br/>

                                                <!-- <div class="form-group">
                                                    <label for="no_surat_ke_gubernur" class="col-lg-2 control-label">No. Surat Permohonan Ke Gubernur</label>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="input-sm form-control" id="no_surat_ke_gubernur" >
                                                    </div>

                                                    <label for="tgl_surat_ke_gubernur" class="col-lg-1 control-label">Tanggal Surat</label>
                                                    <div class="col-lg-2">
                                                        <div class="input-group date" id="tgl_surat_ke_gubernur_date" data-date-format="yyyy-mm-dd">
                                                            <input class="input-sm form-control" id="tgl_surat_ke_gubernur" type="text">
                                                            <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                                                        </div>
                                                    </div>

                                                    <label class="col-lg-1 control-label">File <span style="color:#FF0000;">(.pdf)</span></label>
                                                    <div class="col-lg-2">
                                                        <input type="file" class="input-sm form-control" name="file_surat_ke_gubernur" id="file_surat_ke_gubernur">      
                                                    </div>

                                                    <div class="col-lg-1">
                                                        <div id="btn_file_surat_ke_gubernur"></div>
                                                    </div>
                                                </div> -->

                                                <div class="form-group">
                                                    <label for="no_surat_ke_mendagri" class="col-lg-2 control-label">No. Surat Permohonan Ke Mendagri</label>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="input-sm form-control" id="no_surat_ke_mendagri" >
                                                    </div>

                                                    <label for="tgl_surat_ke_mendagri" class="col-lg-1 control-label">Tanggal Surat</label>
                                                    <div class="col-lg-2">
                                                        <div class="input-group date" id="tgl_surat_ke_mendagri_date" data-date-format="yyyy-mm-dd">
                                                            <input class="input-sm form-control" id="tgl_surat_ke_mendagri" type="text">
                                                            <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                                                        </div>
                                                    </div>

                                                    <label class="col-lg-1 control-label">File <span style="color:#FF0000;">(.pdf)</span></label>
                                                    <div class="col-lg-2">
                                                        <input type="file" class="input-sm form-control" name="file_surat_ke_mendagri" id="file_surat_ke_mendagri">      
                                                    </div>

                                                    <div class="col-lg-1">
                                                        <div id="btn_file_surat_ke_mendagri"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="no_surat_ke_menkeu" class="col-lg-2 control-label">No. Surat Permohonan Ke Menkeu</label>
                                                    <div class="col-lg-2">
                                                        <input type="text" class="input-sm form-control" id="no_surat_ke_menkeu" >
                                                    </div>

                                                    <label for="tgl_surat_ke_menkeu" class="col-lg-1 control-label">Tanggal Surat</label>
                                                    <div class="col-lg-2">
                                                        <div class="input-group date" id="tgl_surat_ke_menkeu_date" data-date-format="yyyy-mm-dd">
                                                            <input class="input-sm form-control" id="tgl_surat_ke_menkeu" type="text">
                                                            <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                                                        </div>
                                                    </div>

                                                    <label class="col-lg-1 control-label">File <span style="color:#FF0000;">(.pdf)</span></label>
                                                    <div class="col-lg-2">
                                                        <input type="file" class="input-sm form-control" name="file_surat_ke_menkeu" id="file_surat_ke_menkeu">      
                                                    </div>

                                                    <div class="col-lg-1">
                                                        <div id="btn_file_surat_ke_menkeu"></div>
                                                    </div>
                                                </div>

                                                <div class="formSep"></div>
                                                <h4>Dokumen Persyaratan</h4><br/>

                                                <div id="divfileFL01" class="form-group">
                                                    <label for="fileFL01" class="col-lg-2 control-label">Latar belakang dan Penjelasan </label>
                                                    <div class="col-lg-2">
                                                        <input type="file" class="input-sm form-control" name="file_ltr_blkng" id="file_ltr_blkng">
                                                        <span class="help-block" style="color:#FF0000;">* Jenis file pdf</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btn_file_ltr_blkng"></div>
                                                    </div>
                                                </div>
                                                
                                                <div id="divfileFL01" class="form-group">
                                                    <label for="fileFL01" class="col-lg-2 control-label">Berita Acara/Naskah Pesetujuan 
                                                        Bersama DPRD dan KDH</label>
                                                    <div class="col-lg-2">
                                                        <input type="file" class="input-sm form-control" name="file_berita_acara" id="file_berita_acara">
                                                        <span class="help-block" style="color:#FF0000;">* Jenis file pdf</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btn_file_berita_acara"></div>
                                                    </div>
                                                </div>
                                              
                                                <div id="divfileFL01" class="form-group">
                                                    <label for="fileFL01" class="col-lg-2 control-label">Batang Tubuh Ranperda/Perda</label>
                                                    <div class="col-lg-2">
                                                        <input type="file" class="input-sm form-control" name="file_ranperda" id="file_ranperda">
                                                        <span class="help-block" style="color:#FF0000;">* Jenis file .doc, docx</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btn_file_ranperda"></div>
                                                    </div>
                                                </div>

                                                <div id="divfileFL01" class="form-group">
                                                    <label for="fileFL01" class="col-lg-2 control-label">Lampiran Batang Tubuh</label>
                                                    <div class="col-lg-2">
                                                        <input type="file" class="input-sm form-control" name="file_lampiran_ranperda" id="file_lampiran_ranperda">
                                                        <span class="help-block" style="color:#FF0000;">* Jenis file .doc, docx</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btn_file_lampiran_ranperda"></div>
                                                    </div>
                                                </div>

                                                <div id="divfileFL01" class="form-group">
                                                    <label for="fileFL01" class="col-lg-2 control-label">Draft Matrik Ranperda</label>
                                                    <div class="col-lg-2">
                                                        <input type="file" class="input-sm form-control" name="file_draft_matrik_ranperda" id="file_draft_matrik_ranperda">
                                                        <span class="help-block" style="color:#FF0000;">* Jenis file .doc, docx</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btn_file_draft_matrik_ranperda"></div>
                                                    </div>
                                                </div>

                                                <div id="divfileRancanganPerda" class="form-group">
                                                    <label for="fileRancanganPerda" class="col-lg-2 control-label">Induk Perda dan Lampiran</label>
                                                    <div class="col-lg-4">
                                                        <input type="file" class="input-sm form-control" name="fileRancanganPerda" id="fileRancanganPerda">
                                                        <span class="help-block" style="color:#FF0000;">* Wajib isi, File yang diperbolehkan hanya .doc dan .docx</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <button class="btn btn-sm btn-default" id="BTN_ADDITEM_KAB01"><i class="splashy-add_small"></i> Tambah Data</button>
                                                    </div>
                                                </div>

                                                <div id="tblKP01"></div> 


                                            </div>
                                        </div>
                                    </div>

                                    <div id="divRevisi" class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapsekab2">Revisi</a>
                                            </h4>
                                        </div>
                                        <div id="collapsekab4" class="panel-collapse collapse in">
                                            <div class="panel-body">

                                                <div class="form-group">
                                                    <label for="fileFL01" class="col-lg-2 control-label">Batang Tubuh Ranperda/Perda</label>
                                                    <div class="col-lg-2">
                                                        <input type="file" class="input-sm form-control" name="file_revisi_ranperda" id="file_revisi_ranperda">
                                                        <span class="help-block" style="color:#FF0000;">* Jenis file .doc, docx</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btn_file_revisi_ranperda"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="fileFL01" class="col-lg-2 control-label">Lampiran Batang Tubuh</label>
                                                    <div class="col-lg-2">
                                                        <input type="file" class="input-sm form-control" name="file_revisi_lampiran_ranperda" id="file_revisi_lampiran_ranperda">
                                                        <span class="help-block" style="color:#FF0000;">* Jenis file .doc, docx</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btn_file_revisi_lampiran_ranperda"></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div id="divPenetapanPerda"  class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapsekab2">Penyampaian Penetapan Perda Pajak & Retribusi</a>
                                            </h4>
                                        </div>
                                        <div id="collapsekab2" class="panel-collapse collapse in">
                                            <div class="panel-body">

                                                <div class="form-group">
                                                    <label for="txtRegNo" class="col-lg-2 control-label">No. Registrasi</label>
                                                    <div class="col-lg-3">
                                                        <input type="text" class="input-sm form-control" id="txtRegNo" >
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="txtPerdaNo" class="col-lg-2 control-label">No. Perda</label>
                                                    <div class="col-lg-3">
                                                        <input type="text" class="input-sm form-control" id="txtPerdaNo" >
                                                    </div>
                                                </div>
                                                <div id="divdatetglSP7" class="form-group">
                                                    <label for="datetglSP7" class="col-lg-2 control-label">Tanggal Perda</label>
                                                    <div class="col-lg-2">
                                                        <div class="input-group date" id="datetglSP7_date" data-date-format="yyyy-mm-dd">
                                                            <input class="input-sm form-control" id="datetglSP7" type="text">
                                                            <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="txtDescFilesKP02" class="col-lg-2 control-label">Tentang</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="input-sm form-control" id="txtDescFilesKP02" >
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="fileRancanganPerdaKP02" class="col-lg-2 control-label">Upload File </label>
                                                    <div class="col-lg-4">
                                                        <input type="file" class="input-sm form-control" name="fileRancanganPerdaKP02" id="fileRancanganPerdaKP02">
                                                        <span class="help-block" style="color:#FF0000;">* Wajib isi, File yang diperbolehkan hanya .pdf</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <button class="btn btn-sm btn-default" id="BTN_ADDITEM_KAB02"><i class="splashy-add_small"></i> Tambah Data</button>
                                                    </div>
                                                </div>

                                                <div id="tblKP02"></div>

                                            </div>
                                        </div>
                                    </div>
                                
                                </div>

                            </div>

                        </div>
                    </div>

                    
                </div>
                <div class="tab-pane" id="tab2">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-horizontal" role="form">

                                <div class="panel-group" id="accordion">

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapsepro2">Penyampaian Hasil Evaluasi Mendagri</a>
                                            </h4>
                                        </div>
                                        <div id="collapsepro2" class="panel-collapse collapse in">
                                            <div class="panel-body">

                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">Hasil Evaluasi</label>
                                                    <div class="col-lg-4">
                                                        <select  class="input-sm form-control" name="hasil_evaluasi" id="hasil_evaluasi" >
                                                            <option value="" selected disabled hidden>Choose here</option>
                                                            <option value="S">Persetujuan Mendagri</option>
                                                            <option value="P">Penolakan Mendagri</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">No. Surat Pengantar Mendagri</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="input-sm form-control" name="no_surat_gub_ke_kabkota" id="no_surat_gub_ke_kabkota">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">Tanggal Surat Pengantar </label>
                                                    <div class="col-lg-2">
                                                        <div class="input-group date" id="tgl_surat_gub_ke_kabkota_date" data-date-format="yyyy-mm-dd">
                                                            <input class="input-sm form-control" id="tgl_surat_gub_ke_kabkota" type="text">
                                                            <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                                                        </div>
                                                    </div>
                                                </div>                           

                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">Surat Pengantar Mendagri</label>
                                                    <div class="col-lg-4">
                                                        <input type="file" class="input-sm form-control" name="file_surat_gub_ke_kabkota" id="file_surat_gub_ke_kabkota">
                                                        <span class="help-block" style="color:#FF0000;">* Wajib isi, File yang diperbolehkan hanya pdf</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btn_file_surat_gub_ke_kabkota"></div>
                                                    </div>
                                                </div>

                                                <div class="formSep"></div>
                                                <!-- <h4>Persetujuan Gubernur dalam bentuk Keputusan Gubernur</h4><br/> -->
                                                <h4><div id="provH4"></div></h4><br/>
                                                

                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label"><div id="no_kepgub_label"></div></label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="input-sm form-control" name="no_kepgub" id="no_kepgub" >
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label"><div id="tgl_kepgub_label"></div></label>
                                                    <div class="col-lg-2">
                                                        <div class="input-group date" id="tgl_kepgub_date" data-date-format="yyyy-mm-dd">
                                                            <input class="input-sm form-control" id="tgl_kepgub" type="text" placeholder="yyyy-mm-dd">
                                                            <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                                                        </div>
                                                    </div>
                                                </div>  

                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label"><div id="file_kepgub_label"></div></label>
                                                    <div class="col-lg-4">
                                                        <input type="file" class="input-sm form-control" name="file_kepgub" id="file_kepgub">
                                                        <span class="help-block" style="color:#FF0000;">* Jenis file .pdf</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btn_file_kepgub"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">File Matrik Evaluasi bertandatangan</label>
                                                    <div class="col-lg-4">
                                                        <input type="file" class="input-sm form-control" name="file_ttd_matrik_ev_provinsi" id="file_ttd_matrik_ev_provinsi">
                                                        <span class="help-block" style="color:#FF0000;">* Jenis file .pdf</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btn_file_ttd_matrik_ev_provinsi"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">File Matrik Evaluasi</label>
                                                    <div class="col-lg-4">
                                                        <input type="file" class="input-sm form-control" name="file_edited_matrik_ev_provinsi" id="file_edited_matrik_ev_provinsi">
                                                        <span class="help-block" style="color:#FF0000;">* Jenis file .doc "untuk mempermudah proses selanjutnya"</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btn_file_edited_matrik_ev_provinsi"></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>           

                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="tab-pane" id="tab4">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-horizontal" role="form">

                                <div class="panel-group" id="accordion">

                                    <div id="accKepmen" class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapsekem1">Penyampaian Hasil Evaluasi Mendagri</a>
                                            </h4>
                                        </div>
                                        <div id="collapsekem1" class="panel-collapse collapse in">
                                            <div class="panel-body">

                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">No. Surat Pengantar Mendagri</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="input-sm form-control" name="no_surat_mendagri_kegub" id="no_surat_mendagri_kegub">
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label  class="col-lg-2 control-label">Tanggal Surat Pengantar</label>
                                                    <div class="col-lg-2">
                                                        <div class="input-group date" id="tgl_surat_mendagri_kegub_date" data-date-format="yyyy-mm-dd">
                                                            <input class="input-sm form-control" name="tgl_surat_mendagri_kegub" id="tgl_surat_mendagri_kegub" type="text">
                                                            <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                                                        </div>
                                                    </div>
                                                </div>                           


                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">Upload File Surat Pengantar</label>
                                                    <div class="col-lg-4">
                                                        <input type="file" class="input-sm form-control" name="file_surat_mendagri_kegub" id="file_surat_mendagri_kegub">
                                                        <span class="help-block" style="color:#FF0000;">* Wajib isi, File yang diperbolehkan hanya pdf  </span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btn_file_surat_mendagri_kegub"></div>
                                                    </div>
                                                </div>


                                                <div class="formSep"></div>
                                                <h4>Dokumen Hasil Evaluasi Rancangan Perda atau Perubahan Perda oleh Mendagri </h4><br/>

                                                <div class="form-group">
                                                    <label class="col-lg-2 control-label">No. Surat Keputusan Mendagri</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="input-sm form-control" name="no_kepmendagri" id="no_kepmendagri" >
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label for="tgl_kepmendagri" class="col-lg-2 control-label">Tanggal Keputusan Mendagri</label>
                                                    <div class="col-lg-2">
                                                        <div class="input-group date" id="tgl_kepmendagri_date" data-date-format="yyyy-mm-dd">
                                                            <input class="input-sm form-control" id="tgl_kepmendagri" type="text">
                                                            <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                                                        </div>
                                                    </div>
                                                </div>                           


                                                <div class="form-group">
                                                    <label for="file_kepmendagri" class="col-lg-2 control-label">File Keputusan Mendagri</label>
                                                    <div class="col-lg-4">
                                                        <input type="file" class="input-sm form-control" name="file_kepmendagri" id="file_kepmendagri">
                                                        <span class="help-block" style="color:#FF0000;">* Jenis file .pdf</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btn_file_kepmendagri"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="file_ttd_matrik_ev_mendagri" class="col-lg-2 control-label">File Matrik Evaluasi bertandatangan</label>
                                                    <div class="col-lg-4">
                                                        <input type="file" class="input-sm form-control" name="file_ttd_matrik_ev_mendagri" id="file_ttd_matrik_ev_mendagri">
                                                        <span class="help-block" style="color:#FF0000;">* Jenis file .pdf</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btn_file_ttd_matrik_ev_mendagri"></div>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label for="file_edited_matrik_ev_mendagri" class="col-lg-2 control-label">File Matrik Evaluasi</label>
                                                    <div class="col-lg-4">
                                                        <input type="file" class="input-sm form-control" name="file_edited_matrik_ev_mendagri" id="file_edited_matrik_ev_mendagri">
                                                        <span class="help-block" style="color:#FF0000;">* Jenis file .doc "untuk mempermudah proses selanjutnya"</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btn_file_edited_matrik_ev_mendagri"></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="tab-pane" id="tab5">
                    <table id="tblHistory" class="display" style="width:100%">
                        <thead>
                            <tr>
                            <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Oleh</th>
                                <th>Dari Status</th>
                                <th>Ke Status</th>
                                <th>Alasan</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                            <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Oleh</th>
                                <th>Dari Status</th>
                                <th>Ke Status</th>
                                <th>Alasan</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>