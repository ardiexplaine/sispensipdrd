<style>
.flex-container {
  border-radius: 5px;
  
  display: flex;
}

.flex-container > div {
  border-radius: 5px;
  padding: 8px;
  box-shadow: 1px 1px 2px #888888;
  margin: 4px;

  font-size: 12px;
  vertical-align: top;
}

.redClass{
    background-color: #CF6766 !important;
}




.box1
{
    color:white;
    background-color:#4ABDAC;
    border:1px solid #4ABDAC;
    border-radius: 5px;	
    height: 230px;		
    min-height:200px;	
}

.box2
{
    color:white;
    background-color:#F7882F;
    border:1px solid #F7882F;
    border-radius: 5px;		
    height: 230px;
    min-height:200px;		
}

.box3
{
    color:white;
    background-color:#6C648B;
    border:1px solid #6C648B;
    border-radius: 5px;		
    height: 230px;	
    min-height:200px;
}

</style>


<script type="text/javascript" class="init">
    $(document).ready(function() {
        loaddashboardKab();
        loaddashboardPro();

        function loaddashboardKab() {
            // hapus datatable
            var table = $('#tblDashboardKab').DataTable();
            table.destroy();

            var formData = {
                'wfnum': $('#txtWfnum').val(),
            };

            var cols = [
                { "data": "no","width": "2%" },
                { "data": "wfnum" },
                { "data": "daerah" },
                { "data": "sp_kab_kota" },
                { "data": "tglterima" },
                { "data": "sp_provinsi" },
                { "data": "sp_kemendagri" },
                { "data": "sp_kemenkeu" },
                { "data": "stsnm" },
                { "data": "jml" }
            ];  
            

            $('#tblDashboardKab').DataTable({
                "ajax": {
                    "url": baseurl+"dashboard/loadDashboardKab",
                    "type": "POST",
                    "data": formData,
                    "deferLoading": 57,
                    "scrollY": "200px",
                    "scrollCollapse": true,
                    "paging": false,
                    "dataSrc": ""
                },
                "columns": cols
            });

            $('#tblDashboardKab tbody').on('dblclick', 'tr', function () {
                var table = $('#tblDashboardKab').DataTable();
                var data = table.row( this ).data();
                //alert( 'You clicked on '+data["wfcat"]+'\'s row' );
                if(data["wfcat"] == 'WF01'){
                    location.href = 'ranperda/kabkot/'+data["wfnum"];
                }
                if(data["wfcat"] == 'WF02'){
                    location.href = 'ranperda/provin/'+data["wfnum"];
                }
            });

        }

        function loaddashboardPro() {
            // hapus datatable
            var table = $('#tblDashboardPro').DataTable();
            table.destroy();

            var formData = {
                'wfnum': $('#txtWfnum').val(),
            };

            var cols = [
                { "data": "no","width": "2%" },
                { "data": "wfnum" },
                { "data": "daerah" },
                { "data": "sp_provinsi" },
                { "data": "tglterima" },
                { "data": "sp_kemendagri" },
                { "data": "sp_kemenkeu" },
                { "data": "stsnm" },
                { "data": "jml" }
            ];  
            

            $('#tblDashboardPro').DataTable({
                "ajax": {
                    "url": baseurl+"dashboard/loadDashboardPro",
                    "type": "POST",
                    "data": formData,
                    "deferLoading": 57,
                    "scrollY": "200px",
                    "scrollCollapse": true,
                    "paging": false,
                    "dataSrc": ""
                },
                "columns": cols
            });

            $('#tblDashboardPro tbody').on('dblclick', 'tr', function () {
                var table = $('#tblDashboardPro').DataTable();
                var data = table.row( this ).data();
                //alert( 'You clicked on '+data["wfcat"]+'\'s row' );
                if(data["wfcat"] == 'WF01'){
                    location.href = 'ranperda/kabkot/'+data["wfnum"];
                }
                if(data["wfcat"] == 'WF02'){
                    location.href = 'ranperda/provin/'+data["wfnum"];
                }
            });

        }
    });
</script>
<h3 class="heading">Beranda</h3>

<div class="row">
    <div class="col-lg-4">
        <div class="panel box1">
            <div class="panel-body">
                <div class="row">                 
                <div class="col-xs-12 text-justify">
                        <div>
                        <h3>SISPENSI PDRD</h3>
                        Merupakan layanan penyampaian dokumen rancangan perda pajak daerah dan retribusi daerah berikut dokumentasi hasil evaluasi yang dilakukan oleh Provinsi, Kemendagri dan Kemenkeu secara elektronik.
                        
                        <br/><br/><h3>Panduan Singkat</h3>
                        </div>
                        <div>
                        
                        <table>      
                                <?php
                                $no=1;
                                    $SQL = "SELECT t_info.nm_info 
                                            FROM t_info 
                                            WHERE t_info.isactive ='Y' and t_info.kolom = '1'
                                            ORDER BY no_urut ASC
                                            ";
                                    $query = $this->db->query($SQL);
    
                                    foreach($query->result() as $row)
                                    {
                                        ?>        
                                        <tr>
                                            <td valign="top" width="4%"><?php echo $no;?>. </td> 
                                            <td valign="top" align="justify" width="96%"><?php echo $row->nm_info;?></td>
                                        </tr>                         
                                        <?php
                                        $no++;
                                    }
                                ?>
                        </table>
                        
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="panel box2">
            <div class="panel-body">
                <div class="row">    
                    <div class="col-xs-12 text-justify">
                        <div>
                            <h3>TAHAPAN</h3>
                        </div>

                        <div>
                        Pemerintah Daerah: <br>
                        <table>      
                                <?php
                                $no=1;
                                    $SQL = "SELECT t_info.nm_info 
                                            FROM t_info 
                                            WHERE t_info.isactive ='Y' and t_info.kolom = '2'
                                            ORDER BY no_urut ASC
                                            ";
                                    $query = $this->db->query($SQL);
    
                                    foreach($query->result() as $row)
                                    {
                                        ?>        
                                        <tr>
                                            <td valign="top" width="4%"><?php echo $no;?>. </td> 
                                            <td valign="top" align="justify" width="96%"><?php echo $row->nm_info;?></td>
                                        </tr>                         
                                        <?php
                                        $no++;
                                    }
                                ?>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="panel box3">
            <div class="panel-body">
                <div class="row">
                <div class="col-xs-12 text-justify">
                        <div>
                            <h3>INFORMASI</h3>
                        </div>
                        <div>
                            <table>
                                
                            <?php
                            $no=1;
                                $SQL = "SELECT t_info.nm_info 
                                        FROM t_info 
                                        WHERE t_info.isactive ='Y' and t_info.kolom = '3'
                                        ORDER BY no_urut ASC
                                        ";
                                $query = $this->db->query($SQL);

                                foreach($query->result() as $row)
                                {
                                    ?>        
                                    <tr>
                                        <td valign="top" width="4%"><?php echo $no;?>. </td> 
                                        <td valign="top" align="justify" width="96%"><?php echo $row->nm_info;?></td>
                                    </tr>                         
                                    <?php
                                    $no++;
                                }
                            ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>




<div style="border-radius: 10px; border: 1px solid grey;padding: 10px; width: 100%;height: 100%;">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="tabbable tabbable-bordered">

                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">Kabupaten / Kota</a></li>
                    <?php if($this->session->userdata('user_type') != "KAB" ){ ?>
                    <li><a href="#tab2" data-toggle="tab">Provinsi</a></li>
                    <?php } ?>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                            <table id="tblDashboardKab" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NDI</th>
                                        <th>Daerah</th>
                                        <th>No.Surat Kab/Kota <br> tanggal surat</th>
                                        <th>Diterima lengkap</br>Jatuh Tempo</th>
                                        <th>Surat Provinsi <br> tanggal surat</th>
                                        <th>Surat Kemendagri <br> tanggal surat</th>
                                        <th>Surat Kemenkeu <br> tanggal surat</th>
                                        <th>Status</th>
                                        <th>Sisa Hari kerja</th>
                                    </tr>
                                </thead>
                            </table>
                            </div>
                        </div>
                    </div>
                    
                    <?php if($this->session->userdata('user_type') != "KAB" ){ ?>
                    <div class="tab-pane" id="tab2">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                            <table id="tblDashboardPro" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NDI</th>
                                        <th>Daerah</th>
                                        <th>Surat Provinsi <br> tanggal surat</th>
                                        <th>Diterima lengkap</br>Jatuh Tempo</th>
                                        <th>Surat Kemendagri <br> tanggal surat</th> 
                                        <th>Surat Kemenkeu <br> tanggal surat</th>            
                                        <th>Status</th>
                                        <th>Sisa Hari kerja</th>
                                    </tr>
                                </thead>
                            </table>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                
            </div>
        </div>
    </div>

    <span style="font-style: italic; color:red;">*Double klik untuk mengakses informasi detail</span>
</div>