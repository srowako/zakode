<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 part1">
                <h2 class="page-header">
                    <i class="fa fa-pencil-square-o"></i> APPARINDO
                    <small class="pull-right">093/SK/DP.ABAI/08/2006</small>
                </h2>
                <a href=""><img class="lead" src="assets/frontend/images/logo.png" alt="Logo"></a>
                <h3>Integrity, Trust and Commitment. </h3>
                <p><i class="fa fa-phone"></i>&nbsp;&nbsp; +62 21 799 7044</p>
                <p><i class="fa fa-fax"></i>&nbsp;&nbsp; +62 21 799 7043</p>
                <p>info@aapialang.co.id</p>                                                
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 part2">
                <div class="box box-solid">
                    <div class="box-header with-border">
                      <h3 class="box-title">Double "A" Insurance Broker & Consultant</h3>
                    </div>
                    <div class="box-body">
                      <dl>
                        <dt>PT AA Pialang Asuransi</dt>
                        <dd>Berdiri pada tanggal 1 Oktober 2002.</dd>
                        <dt>No.C-21127 HT.0101</dt>
                        <dd>Terdaftar di Departement Kehakiman & Hak Asasi Manusia.</dd>
                        <dd>Pada tanggal 30 Oktober 2002.</dd>
                        <dt>KEP-195/KM.6/2003</dt>
                        <dd>Izin usaha DepKeu 2 Juni 2003.</dd>
                      </dl>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 part4">
                <div class="box box-solid">
                    <div class="box-header with-border">
                      <h3 class="box-title">Integrity, Trust and Commitment</h3>
                    </div>
                    <div class="box-body">
                      <div class="box-group" id="accordion">
                        <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h4 class="box-title">
                              <a class="collapsed" aria-expanded="false" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                Divisi Syariah
                              </a>
                            </h4>
                          </div>
                          <div style="height: 0px;" aria-expanded="false" id="collapseOne" class="panel-collapse collapse">
                            <div class="box-body">
                              Sejak bulan Maret 2006 PT AA PIALANG ASURANSI
                              telah membuka Divisi Syariah sesuai dengan
                              rekomendasi Dewan Syariah Nasional MUI melalui
                              surat No.U-054/DSN-MUI/III/2006 tanggal 13 Maret 2006
                              dan surat rekomendasi dari Departemen Keuangan
                              Republik Indonesian No.S-1001/LK/2006
                              Tertanggal 27 Maret 2006, Sehingga kami lebih 
                              kompeten lagi untuk menangani kebutuhan Asuransi Syariah
                            </div>
                          </div>
                        </div>
                        <div class="panel box box-danger">
                          <div class="box-header with-border">
                            <h4 class="box-title">
                              <a aria-expanded="false" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                VISI
                              </a>
                            </h4>
                          </div>
                          <div style="height: 0px;" aria-expanded="false" id="collapseTwo" class="panel-collapse collapse">
                            <div class="box-body">
                              "Memberikan kenyamanan dalam pengalaman konsultasi manajemen resiko yang terbaik dan berkualitas adalah komitmen kami"
                            </div>
                          </div>
                        </div>
                        <div class="panel box box-success">
                          <div class="box-header with-border">
                            <h4 class="box-title">
                              <a aria-expanded="false" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                MISI
                              </a>
                            </h4>
                          </div>
                          <div style="height: 0px;" aria-expanded="false" id="collapseThree" class="panel-collapse collapse">
                            <div class="box-body">
                              "Dalam membangun pondasi yang kuat sebagai salah satu perusahaan pialang dan konsultasi asuransi yang dapat dipercaya.
                              PT AA Pialang Asuransi dengan penuh loyalitas, peka terhadap kebutuhan nasabah dan terintegrasi dengan sumber daya
                              manusia yang solid serta berpengalaman yang terbaik pada tertanggung dan penanggung, serta memberikan keuntungan yang terbaik bagi para stakeholder"
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <?php if (ENVIRONMENT=='development'): ?>
            <p class="pull-right hidden-xs">
                ZaKode modules - Version: <strong><?php echo ZaKode_VERSION; ?></strong>, 
                CI Version: <strong><?php echo CI_VERSION; ?></strong>, 
                Elapsed Time: <strong>{elapsed_time}</strong> seconds, 
                Memory Usage: <strong>{memory_usage}</strong> 
            </p>
        <?php endif; ?>
            <p class="float_left"><strong>Copyright &copy; 2014-<?php echo date('Y'); ?></strong> <a href="http://www.reko.web.id">Reko Srowako</a> All rights reserved.</p>
    </div>
</footer>
<?php // script foot ?>
<?php
        foreach ($scripts['foot'] as $file){
                $url = starts_with($file, 'http') ? $file : base_url($file);
                echo "<script src='$url'></script>".PHP_EOL;
        }
?>
<?php // Google Analytics ?>
<?php echo $template['partials']['fe_ga']; ?>

