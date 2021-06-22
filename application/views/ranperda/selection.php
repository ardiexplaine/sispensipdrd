<script type="text/javascript" class="init">
    $(document).ready(function() {
        
        $('#listSelection').hide();
        jenisStatus();
        $('#slcDaerahProv').on('change', function() {
            slckabkot('');
        });


        $('#ADD_NEW').on('click', function() {
            if($(this).val() == 'KAB'){
                location.href = '/sispensi/ranperda/kabkot';
            }
            if($(this).val() == 'PRO'){
                location.href = '/sispensi/ranperda/provin';
            }
            
        });
        $('#BTN_BACK_SELECT').on('click', function() {
            $('#listSelection').hide();
            $('#formSelection').show();
        });
        

        $('#BTN_SEARCH').on('click', function() {
            var data = new FormData();


            data.append('wfnum', $('#slcWfnum').val());
            data.append('slcSuPeng', $("#slcSuPeng").val());
            data.append('slcDaerahKab', $("#slcDaerahKab").val());
            data.append('slcJenisStatus', $("#slcJenisStatus").val());
                  
            $.ajax({
                url: baseurl+"ranperda/searchData",
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
                        $('#listSelection').show();
                        $('#formSelection').hide();

                        var table = $('#tblListRanperda').DataTable();
                        table.destroy();
                        var oTblReport = $("#tblListRanperda")
                        oTblReport.DataTable ({
                            "data" : data.result,
                            "columns" : [
                                { "data" : "wfnum" },
                                { "data" : "zuser" },
                                { "data" : "stsnm" },
                                { "data" : "no_surat_ke_gubernur" },
                                { "data" : "no_surat_ke_mendagri" },
                                { "data" : "no_surat_ke_menkeu" },
                                { "data" : "spskd" },
                            ]
                        });

                        $('#tblListRanperda tbody').on('click', 'tr', function () {
                            var table = $('#tblListRanperda').DataTable();
                            var data = table.row( this ).data();
                            //alert( 'You clicked on '+data["wfcat"]+'\'s row' );
                            if(data["wfcat"] == 'WF01'){
                                location.href = 'ranperda/kabkot/'+data["wfnum"];
                            }
                            if(data["wfcat"] == 'WF02'){
                                location.href = 'ranperda/provin/'+data["wfnum"];
                            }
                        });

                        document.getElementById('ztxtAppsMsg').innerHTML = '';
                    }else{

                        document.getElementById('ztxtAppsMsg').innerHTML = data.notif;
                    }
                    
                    //document.getElementById('ztxtAppsMsg').innerHTML = data.message;			
                },
                error: function(xhr, ajaxOptions, thrownError){
                    alert(xhr.responseText);
                    $('body').css('cursor','default');			
                }
            });
        });

    });
</script>
<h3 class="heading">RANPERDA</h3>

<div id="formSelection">

    <div class="row">
        <div class="col-sm-7 col-md-7">
            <div id="zbtnAction" class="form-actions">
                <button class="btn btn-sm btn-default" id="BTN_SEARCH"><i class="splashy-zoom"></i> Cari Dokumen</button>
            </div>
        </div>
        <div class="col-sm-5 col-md-5">
            <div id="ztxtAppsMsg"></div>
        </div>
    </div>
    <br/>

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-horizontal" role="form">

                <div class="col-sm-10 col-md-10">
                    <div id="divslcJenisPR" class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">No. Dok. Input (NDI)</label>
                        <div class="col-lg-4">
                            <input type="text" class="input-sm form-control" id="slcWfnum">
                        </div>
                    </div>
                </div>	

                <div class="col-sm-10 col-md-10">
                    <div id="divslcslcSuPeng" class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">No. Surat Pengantar</label>
                        <div class="col-lg-4">
                            <input type="text" class="input-sm form-control" id="slcSuPeng">
                        </div>
                    </div>
                </div>	

                <?php if($this->session->userdata('user_type') != 'KAB') { ?>
                <div class="col-sm-10 col-md-10">
                    <div id="divslcDaerahProv" class="form-group">
                        <label for="inputEmail1" class="col-lg-2 control-label">Daerah</label>
                        <div class="col-lg-3">
                            <?php
                                //$this->load->library('database');
                                $guser = $this->session->userdata('group_user');
                                $conds = '';
                                if($this->session->userdata('user_type') == 'PRO') {
                                    $conds .= "AND id=$guser ";
                                }
                                $query = $this->db->query("SELECT * FROM hirarki WHERE kodekab=0 $conds");
                                $option = array();
                                $option[] = '- Semua Data';
                                foreach($query->result() as $row) :
                                $option[$row->kodeprov] = $row->namakab;
                                endforeach;
                                $js = 'id="slcDaerahProv" class="input-sm form-control"';
                                echo form_dropdown('slcDaerahProv', $option, '',$js); 
                            ?>
                        </div>
                        <div class="col-lg-4">
                            <select class="input-sm form-control" id="slcDaerahKab">
                                <option value="">- Semua Data</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php } ?>	

                <div class="col-sm-10 col-md-10">
                    <div id="divslcJenisStatus" class="form-group">
                        <label for="slcJenisStatus" class="col-lg-2 control-label">Status Ranperda</label>
                        <div class="col-lg-4">
                            <select class="input-sm form-control" id="slcJenisStatus"></select>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> 


    	

</div>

<div id="listSelection">

    <div class="row">
        <div class="col-sm-7 col-md-7">
            <div id="zbtnAction" class="form-actions">
                <button class="btn btn-sm btn-default" id="BTN_BACK_SELECT"><i class="splashy-arrow_medium_left"></i> Back To Selection</button>
            </div>
        </div>
        <div class="col-sm-5 col-md-5">
            <div id="ztxtAppsMsg"></div>
        </div>
    </div>
    <br/>
    
    <table id="tblListRanperda" class="display" style="width:100%">
        <thead>
            <tr>
                <th>NDI.</th>
                <th>Daerah</th>
                <th>Status</th>
                <th>SP. Kab/Kota</th>
                <th>SP. Gubernur</th>
                <th>SP. Kemendagri</th>
                <th>SP. Sekda</th>
            </tr>
        </thead>
    </table>
</div>