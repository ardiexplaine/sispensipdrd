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
        loaddashboard();

        function loaddashboard() {
            // hapus datatable
            var table = $('#tblDashboard').DataTable();
            table.destroy();

            var formData = {
                'wfnum': $('#txtWfnum').val(),
            };

            var cols = [
                { "data": "no","width": "2%" },
                { "data": "stsnm" },
                { "data": "jml","width": "20%" }
            ];   

            $('#tblDashboard').DataTable({
                "ajax": {
                    "url": baseurl+"dashboard/loadDashboard",
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
                <table id="tblDashboard" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NDI</th>
                            <th>Daerah</th>
                            <th>No.Surat Kab/Kota <br> tanggal surat</th>
                            <th>tgl Diterima lengkap</th>
                            <th>Surat Kemenkeu <br> tanggal surat</th>
                            <th>Surat Kemendagri <br> tanggal surat</th>
                            <th>Surat Provinsi <br> tanggal surat</th>
                            <th>Stattus</th>
                            <th>Sisa Hari kerja</th>
                            <th>Tgl. Jatuh Tempo</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <span style="font-style: italic; color:red;">*Double klik untuk mengakses informasi detail</span>
</div>