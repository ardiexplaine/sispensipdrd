<script type="text/javascript" class="init">
    $(document).ready(function() {

        var wfnum = $('#txtWfnum').val();
        if(wfnum != ''){
            loaddata();
        }else{
            workflow();
            getCodeNDI();
            loadStatus('RNA1');
            roleScreen('RNA1','');
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
        // $('#file_surat_menkeu_ke_mendagri').on("change", function(){ doUploads('file_surat_menkeu_ke_mendagri', ["pdf"]); });
        // $('#file_kepmenkeu').on("change", function(){ doUploads('file_kepmenkeu', ["pdf"]); });
        // $('#file_ttd_matrik_ev_menkeu').on("change", function(){ doUploads('file_ttd_matrik_ev_menkeu', ["pdf"]); });
        // $('#file_edited_matrik_ev_menkeu').on("change", function(){ doUploads('file_edited_matrik_ev_menkeu', ["doc", "docx"]); });

        // Mendagri
        $('#file_surat_mendagri_kegub').on("change", function(){ doUploads('file_surat_mendagri_kegub', ["pdf"]); });
        $('#file_kepmendagri').on("change", function(){ doUploads('file_kepmendagri', ["pdf"]); });
        $('#file_ttd_matrik_ev_mendagri').on("change", function(){ doUploads('file_ttd_matrik_ev_mendagri', ["pdf"]); });
        $('#file_edited_matrik_ev_mendagri').on("change", function(){ doUploads('file_edited_matrik_ev_mendagri', ["doc", "docx"]); });
        


        

        // datepicker
        datepic('tgl_surat_ke_gubernur','yyyy-mm-dd');
        datepic('tgl_surat_ke_mendagri','yyyy-mm-dd');
        datepic('tgl_surat_ke_menkeu','yyyy-mm-dd');
        datepic('tgl_surat_menkeu_ke_mendagri','yyyy-mm-dd');
        datepic('tgl_kepmenkeu','yyyy-mm-dd');
        datepic('tgl_surat_gub_ke_kabkota','yyyy-mm-dd');
        datepic('tgl_kepgub','yyyy-mm-dd');
        datepic('tgl_surat_mendagri_kegub','yyyy-mm-dd');
        datepic('tgl_kepmendagri','yyyy-mm-dd');
        datepic('datetglSP7','yyyy-mm-dd');
        
        
        
        

        

        // $('#jns_pad').on('change', function() {
        //     funcSelectAttr('PAD','','jns_pajak',$(this).val());
        // });

        $('#hasil_evaluasi').on('change', function() {
            hasilEvaluasi('WF01',$(this).val());
        });

        

    });
</script>
<h3 class="heading"><strong>RANPERDA > <i>KABUPATEN KOTA </i> <i id="redLabel"></i></strong>
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

        </table> 
    </div>	
</div>

<div class="row" id="tabBody">
    <div class="col-sm-12 col-md-12">

        <div class="form-horizontal" role="form">

            <div id="divPenetapanPerda1"  class="panel panel-default">
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

            <div id="divPenetapanPerda2"  class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapsekab3">Provinsi</a>
                    </h4>
                </div>
                <div id="collapsekab3" class="panel-collapse collapse in">
                    <div class="panel-body">
                        
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

            <div id="divPenetapanPerda3"  class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapsekab4">Kemenkeu</a>
                    </h4>
                </div>
                <div id="collapsekab4" class="panel-collapse collapse in">
                    <div class="panel-body">
                        
                            <div id="divtxtSPGubernur" class="form-group">
                                <label for="txtSPGubernur" class="col-lg-2 control-label">No. Surat Keputusan Menkeu</label>
                                <div class="col-lg-4">
                                    <input type="text" class="input-sm form-control" id="txtSPGubernur-kem" disabled>
                                </div>
                            </div>



                            <div id="divdatetglSP3" class="form-group">
                                <label for="datetglSP3" class="col-lg-2 control-label">Tanggal Keputusan Menkeu</label>
                                <div class="col-lg-2">
                                    <div class="input-group date" id="tglSP3" data-date-format="yyyy-mm-dd">
                                        <input class="input-sm form-control" id="datetglSP3" type="text">
                                        <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                                    </div>
                                </div>
                            </div>                           


                            <div id="divfileRancanganPerdaPR02" class="form-group">
                                <label for="fileRancanganPerdaPR02" class="col-lg-2 control-label">File Keputusan Menkeu</label>
                                <div class="col-lg-4">
                                    <input type="file" class="input-sm form-control" name="fileRancanganPerdaPR02" id="fileRancanganPerdaPR02">
                                    <span class="help-block" style="color:#FF0000;">* Jenis file .pdf</span>
                                </div>
                            </div>
                            <div id="divfileRancanganPerdaPR02" class="form-group">
                                <label for="fileRancanganPerdaPR02" class="col-lg-2 control-label">File Matrik Evaluasi bertandatangan</label>
                                <div class="col-lg-4">
                                    <input type="file" class="input-sm form-control" name="fileRancanganPerdaPR02" id="fileRancanganPerdaPR02">
                                    <span class="help-block" style="color:#FF0000;">* Jenis file .pdf</span>
                                </div>
                            </div>
                            <div id="divfileRancanganPerdaPR02" class="form-group">
                                <label for="fileRancanganPerdaPR02" class="col-lg-2 control-label">File Matrik Evaluasi</label>
                                <div class="col-lg-4">
                                    <input type="file" class="input-sm form-control" name="fileRancanganPerdaPR02" id="fileRancanganPerdaPR02">
                                    <span class="help-block" style="color:#FF0000;">* Jenis file .doc "untuk mempermudah proses selanjutnya"</span>
                                </div>
                            </div>

                    </div>
                </div>
            </div>

            <div id="divPenetapanPerda4"  class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapsekab5">Kemendagri</a>
                    </h4>
                </div>
                <div id="collapsekab5" class="panel-collapse collapse in">
                    <div class="panel-body">

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