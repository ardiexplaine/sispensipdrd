<script type="text/javascript" class="init">
    $(document).ready(function() {

        var wfnum = $('#txtWfnum').val();
        if(wfnum != ''){
            loaddata();
        }else{
            workflow();
            //$('#txtWfnum').val(getCodeNOS('PRV-',9));
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
        $('#BTN_ADDITEM_KEM01').on('click', function() {
            addItem('KM01',getCodeNOS('IT',7),'txtDescFilesKM01','fileRancanganPerdaKM01');
        });
        $('#BTN_ADDITEM_KAB02').on('click', function() {
            addItem('KP02',getCodeNOS('IT',7),'txtDescFilesKP02','fileRancanganPerdaKP02');
        });


        $('#tglSP1').datepicker({format: "yyyy-mm-dd"}).on('changeDate', function(ev){
            var dateText = $(this).data('date');
            $('#datetglSP1').val(dateText);
            $('#tglSP1').datepicker('hide');
        });
        $('#tglSP2').datepicker({format: "yyyy-mm-dd"}).on('changeDate', function(ev){
            var dateText = $(this).data('date');
            $('#datetglSP2').val(dateText);
            $('#tglSP2').datepicker('hide');
        });
        $('#tglSP3').datepicker({format: "yyyy-mm-dd"}).on('changeDate', function(ev){
            var dateText = $(this).data('date');
            $('#datetglSP3').val(dateText);
            $('#tglSP3').datepicker('hide');
        });
        $('#tglSP4').datepicker({format: "yyyy-mm-dd"}).on('changeDate', function(ev){
            var dateText = $(this).data('date');
            $('#datetglSP4').val(dateText);
            $('#tglSP4').datepicker('hide');
        });
        $('#tglSP5').datepicker({format: "yyyy-mm-dd"}).on('changeDate', function(ev){
            var dateText = $(this).data('date');
            $('#datetglSP5').val(dateText);
            $('#tglSP5').datepicker('hide');
        });
        $('#tglSP6').datepicker({format: "yyyy-mm-dd"}).on('changeDate', function(ev){
            var dateText = $(this).data('date');
            $('#datetglSP6').val(dateText);
            $('#tglSP6').datepicker('hide');
        });
        $('#tglSP7').datepicker({format: "yyyy-mm-dd"}).on('changeDate', function(ev){
            var dateText = $(this).data('date');
            $('#datetglSP7').val(dateText);
            $('#tglSP7').datepicker('hide');
        });

    });
</script>
<h3 class="heading">RANPERDA > <i>PROVINSI</i></h3>

<div class="row">
    <div class="col-sm-7 col-md-7">
        <div id="zbtnAction" class="form-actions"></div>
    </div>
    <div class="col-sm-5 col-md-5">
        <div id="ztxtAppsMsg"></div>
    </div>
</div>

<div class="row">
    <div class="col-sm-10 col-md-10">
        <div id="divslcJenisPR" class="form-group">
            <label for="inputEmail1" class="col-lg-3 control-label"><h4>No. Dokumen Input (NDI)</h4></label>
            <div class="col-lg-2">
                <input type="text" class="input-sm form-control" id="txtWfnum" readonly="readonly" value="<?php echo isset($wfnum) ? $wfnum : ''; ?>">
            </div>
            <div class="col-lg-4">
                <input type="hidden" id="txtStatusCd" readonly="readonly">
                <input type="text" class="input-sm form-control" id="txtStatusNm" readonly="readonly">
            </div>
        </div>
    </div>	
</div>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="tabbable tabbable-bordered">
            <ul class="nav nav-tabs">
                <li id="tabpro" class="active"><a href="#tab1" data-toggle="tab">Provinsi</a></li>
                <li id="tabkem"><a href="#tab2" data-toggle="tab">Kemendagri</a></li>
                <li id="tabkem"><a href="#tab3" data-toggle="tab">Kemenkeu</a></li>
                <li id="tabhistory"><a href="#tab4" data-toggle="tab">Riwayat</a></li>
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
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapsekab1">Penyampaian Rancangan Perda</a>
                                            </h4>
                                        </div>
                                        <div id="collapsekab1" class="panel-collapse collapse in">
                                            <div class="panel-body">

                                                <div id="divtxtSPBupati" class="form-group">
                                                    <label for="txtSPBupati" class="col-lg-2 control-label">No. Surat Pengantar Gubernur</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="input-sm form-control" id="txtSPBupati" >
                                                    </div>
                                                </div>

                                                <div id="divdatetglSP1" class="form-group">
                                                    <label for="datetglSP1" class="col-lg-2 control-label">Tanggal Surat Pengantar</label>
                                                    <div class="col-lg-2">
                                                        <div class="input-group date" id="tglSP1" data-date-format="yyyy-mm-dd">
                                                            <input class="input-sm form-control" id="datetglSP1" type="text">
                                                            <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                                                        </div>
                                                    </div>
                                                </div>                           

                                                <div id="divtxtKabDesc" class="form-group">
                                                    <label for="txtKabDesc" class="col-lg-2 control-label">Prihal Surat</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="input-sm form-control" id="txtKabDesc" >
                                                    </div>
                                                </div>

                                                <div id="divtxtKabIsiSurat" class="form-group">
                                                    <label for="txtKabIsiSurat" class="col-lg-2 control-label">Isi Surat/Rincian Ranperda</label>
                                                    <div class="col-lg-6">
                                                        <textarea class="input-sm form-control" rows="4" cols="50" id="txtKabIsiSurat" ></textarea>
                                                    </div>
                                                </div>


                                                <div id="divfileFL01" class="form-group">
                                                    <label for="fileFL01" class="col-lg-2 control-label">Surat Pengantar</label>
                                                    <div class="col-lg-4">
                                                        <input type="file" class="input-sm form-control" id="fileFL01">
                                                        <span class="help-block" style="color:#FF0000;">* Wajib isi, File yang diperbolehkan hanya pdf, jpg, png</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btnFL01"></div>
                                                    </div>
                                                </div>
                                                
                                                <div id="divfileFL02" class="form-group">
                                                    <label for="fileFL02" class="col-lg-2 control-label">Kesepakatan DPRD</label>
                                                    <div class="col-lg-4">
                                                        <input type="file" class="input-sm form-control" id="fileFL02">
                                                        <span class="help-block" style="color:#FF0000;">* Wajib isi, File yang diperbolehkan hanya pdf, jpg, png</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btnFL02"></div>
                                                    </div>
                                                </div>

                                                <div class="formSep"></div>
                                                <h4>Dokumen Rancangan Perda</h4><br/>

                                                <div id="divtxtDescFiles" class="form-group">
                                                    <label for="txtDescFiles" class="col-lg-2 control-label">Deskripsi File </label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="input-sm form-control" id="txtDescFiles" >
                                                    </div>
                                                </div>

                                                <div id="divfileRancanganPerda" class="form-group">
                                                    <label for="fileRancanganPerda" class="col-lg-2 control-label">Upload File </label>
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

                                    <div id="accUploadPerda" class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapsekab2">Penyampaian Perda Pajak dan Retribusi</a>
                                            </h4>
                                        </div>
                                        <div id="collapsekab2" class="panel-collapse collapse in">
                                            <div class="panel-body">

                                                <div id="divtxtRegNo" class="form-group">
                                                    <label for="txtRegNo" class="col-lg-2 control-label">No. Registrasi</label>
                                                    <div class="col-lg-3">
                                                        <input type="text" class="input-sm form-control" id="txtRegNo" >
                                                    </div>
                                                </div>
                                                <div id="divtxtPerdaNo" class="form-group">
                                                    <label for="txtPerdaNo" class="col-lg-2 control-label">No. Perda</label>
                                                    <div class="col-lg-3">
                                                        <input type="text" class="input-sm form-control" id="txtPerdaNo" >
                                                    </div>
                                                </div>
                                                <div id="divdatetglSP7" class="form-group">
                                                    <label for="datetglSP7" class="col-lg-2 control-label">Tanggal Perda</label>
                                                    <div class="col-lg-2">
                                                        <div class="input-group date" id="tglSP7" data-date-format="yyyy-mm-dd">
                                                            <input class="input-sm form-control" id="datetglSP7" type="text">
                                                            <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="divtxtDescFilesKP02" class="form-group">
                                                    <label for="txtDescFilesKP02" class="col-lg-2 control-label">Tentang </label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="input-sm form-control" id="txtDescFilesKP02" >
                                                    </div>
                                                </div>

                                                <div id="divfileRancanganPerdaKP02" class="form-group">
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

                                    <div id="accKepmen" class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapsekem1">Penyampaian Keputusan Mendagri</a>
                                            </h4>
                                        </div>
                                        <div id="collapsekem1" class="panel-collapse collapse in">
                                            <div class="panel-body">

                                                <div id="divtxtSPBupati" class="form-group">
                                                    <label for="txtSPBupati" class="col-lg-2 control-label">No. Surat Pengantar Gubernur</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="input-sm form-control" id="txtSPBupati-prov" disabled>
                                                    </div>
                                                </div>

                                                <div id="divtxtSpMdn" class="form-group">
                                                    <label for="txtSpMdn" class="col-lg-2 control-label">No. Surat Pengantar KDN</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="input-sm form-control" id="txtSpMdn">
                                                    </div>
                                                </div>

                                                <div id="divdatetglSP3" class="form-group">
                                                    <label for="datetglSP3" class="col-lg-2 control-label">Tanggal Surat Pengantar</label>
                                                    <div class="col-lg-2">
                                                        <div class="input-group date" id="tglSP3" data-date-format="yyyy-mm-dd">
                                                            <input class="input-sm form-control" id="datetglSP3" type="text">
                                                            <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                                                        </div>
                                                    </div>
                                                </div>                           

                                                <div id="divtxtKemDesc" class="form-group">
                                                    <label for="txtKemDesc" class="col-lg-2 control-label">Prihal Surat</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="input-sm form-control" id="txtKemDesc" >
                                                    </div>
                                                </div>

                                                <div id="divtxtKemIsiSurat" class="form-group">
                                                    <label for="txtKemIsiSurat" class="col-lg-2 control-label">Isi Surat/Rincian Ranperda</label>
                                                    <div class="col-lg-6">
                                                        <textarea class="input-sm form-control" rows="4" cols="50" id="txtKemIsiSurat" ></textarea>
                                                    </div>
                                                </div>

                                                <div id="divfileFL04" class="form-group">
                                                    <label for="fileFL04" class="col-lg-2 control-label">Upload File Surat Pengantar</label>
                                                    <div class="col-lg-4">
                                                        <input type="file" class="input-sm form-control" id="fileFL04">
                                                        <span class="help-block" style="color:#FF0000;">* Wajib isi, File yang diperbolehkan hanya pdf, jpg, png</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btnFL04"></div>
                                                    </div>
                                                </div>

                                                <div class="formSep"></div>
                                                <h4>Keputusan Mendagri</h4><br/>

                                                <div id="divtxtDescFilesKM01" class="form-group">
                                                    <label for="txtDescFilesKM01" class="col-lg-2 control-label">Deskripsi File </label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="input-sm form-control" id="txtDescFilesKM01" >
                                                    </div>
                                                </div>

                                                <div id="divfileRancanganPerdaKM01" class="form-group">
                                                    <label for="fileRancanganPerdaKM01" class="col-lg-2 control-label">Upload File </label>
                                                    <div class="col-lg-4">
                                                        <input type="file" class="input-sm form-control" name="fileRancanganPerdaKM01" id="fileRancanganPerdaKM01">
                                                        <span class="help-block" style="color:#FF0000;">* Wajib isi, File yang diperbolehkan hanya .pdf</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <button class="btn btn-sm btn-default" id="BTN_ADDITEM_KEM01"><i class="splashy-add_small"></i> Tambah Data</button>
                                                    </div>
                                                </div>

                                                <div id="tblKM01"></div>

                                            </div>
                                        </div>
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab3">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-horizontal" role="form">

                                <div class="panel-group" id="accordion">

                                    <div id="accKepmen" class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapsekem1">Penyampaian Keputusan Mendagri</a>
                                            </h4>
                                        </div>
                                        <div id="collapsekem1" class="panel-collapse collapse in">
                                            <div class="panel-body">

                                                <div id="divtxtSPBupati" class="form-group">
                                                    <label for="txtSPBupati" class="col-lg-2 control-label">No. Surat Pengantar Gubernur</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="input-sm form-control" id="txtSPBupati-prov" disabled>
                                                    </div>
                                                </div>

                                                <div id="divtxtSpMdn" class="form-group">
                                                    <label for="txtSpMdn" class="col-lg-2 control-label">No. Surat Pengantar KDN</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="input-sm form-control" id="txtSpMdn">
                                                    </div>
                                                </div>

                                                <div id="divdatetglSP3" class="form-group">
                                                    <label for="datetglSP3" class="col-lg-2 control-label">Tanggal Surat Pengantar</label>
                                                    <div class="col-lg-2">
                                                        <div class="input-group date" id="tglSP3" data-date-format="yyyy-mm-dd">
                                                            <input class="input-sm form-control" id="datetglSP3" type="text">
                                                            <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
                                                        </div>
                                                    </div>
                                                </div>                           

                                                <div id="divtxtKemDesc" class="form-group">
                                                    <label for="txtKemDesc" class="col-lg-2 control-label">Prihal Surat</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="input-sm form-control" id="txtKemDesc" >
                                                    </div>
                                                </div>

                                                <div id="divtxtKemIsiSurat" class="form-group">
                                                    <label for="txtKemIsiSurat" class="col-lg-2 control-label">Isi Surat/Rincian Ranperda</label>
                                                    <div class="col-lg-6">
                                                        <textarea class="input-sm form-control" rows="4" cols="50" id="txtKemIsiSurat" ></textarea>
                                                    </div>
                                                </div>

                                                <div id="divfileFL04" class="form-group">
                                                    <label for="fileFL04" class="col-lg-2 control-label">Upload File Surat Pengantar</label>
                                                    <div class="col-lg-4">
                                                        <input type="file" class="input-sm form-control" id="fileFL04">
                                                        <span class="help-block" style="color:#FF0000;">* Wajib isi, File yang diperbolehkan hanya pdf, jpg, png</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div id="btnFL04"></div>
                                                    </div>
                                                </div>

                                                <div class="formSep"></div>
                                                <h4>Keputusan Mendagri</h4><br/>

                                                <div id="divtxtDescFilesKM01" class="form-group">
                                                    <label for="txtDescFilesKM01" class="col-lg-2 control-label">Deskripsi File </label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="input-sm form-control" id="txtDescFilesKM01" >
                                                    </div>
                                                </div>

                                                <div id="divfileRancanganPerdaKM01" class="form-group">
                                                    <label for="fileRancanganPerdaKM01" class="col-lg-2 control-label">Upload File </label>
                                                    <div class="col-lg-4">
                                                        <input type="file" class="input-sm form-control" name="fileRancanganPerdaKM01" id="fileRancanganPerdaKM01">
                                                        <span class="help-block" style="color:#FF0000;">* Wajib isi, File yang diperbolehkan hanya .pdf</span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <button class="btn btn-sm btn-default" id="BTN_ADDITEM_KEM01"><i class="splashy-add_small"></i> Tambah Data</button>
                                                    </div>
                                                </div>

                                                <div id="tblKM01"></div>

                                            </div>
                                        </div>
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab4">
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