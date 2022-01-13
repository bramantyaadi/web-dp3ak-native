<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	echo "<script>alert('Untuk mengakses modul, Anda harus login dulu.'); window.location = 'index.php'</script>"; 
}
// Apabila user sudah login dengan benar, maka terbentuklah session

else{
?>
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
         
        </div>
		Copyright &copy; 2020 <?php echo $tdin['nama_pemilik']; ?>. All rights reserved. msnsolutindo.com
      </footer>
	  
	  <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
		</ul>
		<div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane" id="control-sidebar-home-tab">
		  </div>
		</div>
	  </aside>
	  <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
	
    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/select2.full.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- date-range-picker -->
    <script src="plugins/moment/moment.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="plugins/chartjs/Chart.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
	<!-- CK Editor -->
    <script src="plugins/ckeditor/ckeditor.js"></script>
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
	<script>		
	<?php
	if($_GET['module']=='beranda') {
	?>
	  $(function () {
  'use strict';

  /* ChartJS
   * -------
   * Here we will create a few charts using ChartJS
   */

  //-----------------------
  //- MONTHLY SALES CHART -
  //-----------------------

  // Get context with jQuery - using jQuery's .get() method.
  var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
  // This will get the first returned node in the jQuery collection.
  var salesChart = new Chart(salesChartCanvas);

  var salesChartData = {
    labels: [<?php echo $tanggal; ?>],
    //labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    datasets: [
      {
        label: "Hits",
        fillColor: "rgb(210, 214, 222)",
        strokeColor: "rgb(210, 214, 222)",
        pointColor: "rgb(210, 214, 222)",
        pointStrokeColor: "#c1c7d1",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgb(220,220,220)",
        data: [<?php echo $hits; ?>]
      },
      {
        label: "Pengunjung",
        fillColor: "rgba(60,141,188,0.9)",
        strokeColor: "rgba(60,141,188,0.8)",
        pointColor: "#3b8bba",
        pointStrokeColor: "rgba(60,141,188,1)",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(60,141,188,1)",
        data: [<?php echo $pengunjung; ?>]
      }
    ]
  };

  var salesChartOptions = {
    //Boolean - If we should show the scale at all
    showScale: true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines: false,
    //String - Colour of the grid lines
    scaleGridLineColor: "rgba(0,0,0,.05)",
    //Number - Width of the grid lines
    scaleGridLineWidth: 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines: true,
    //Boolean - Whether the line is curved between points
    bezierCurve: true,
    //Number - Tension of the bezier curve between points
    bezierCurveTension: 0.3,
    //Boolean - Whether to show a dot for each point
    pointDot: false,
    //Number - Radius of each point dot in pixels
    pointDotRadius: 4,
    //Number - Pixel width of point dot stroke
    pointDotStrokeWidth: 1,
    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    pointHitDetectionRadius: 20,
    //Boolean - Whether to show a stroke for datasets
    datasetStroke: true,
    //Number - Pixel width of dataset stroke
    datasetStrokeWidth: 2,
    //Boolean - Whether to fill the dataset with a color
    datasetFill: true,
    //String - A legend template
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%=datasets[i].label%></li><%}%></ul>",
    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: true,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true
  };

  //Create the line chart
  salesChart.Line(salesChartData, salesChartOptions);

  //---------------------------
  //- END MONTHLY SALES CHART -
  //---------------------------
  });
  <?php
  }
  ?>
  
      $(function () {
        $("#datamodul").DataTable();
        $('#datauser').DataTable();
        $('#datatemplates').DataTable();
        $('#datamenu').DataTable();
        $('#databerita').DataTable();
        $('#datakategori').DataTable();
        $('#datahalamanstatis').DataTable();
        $('#databanner').DataTable();
        $('#dataagenda').DataTable();
        $('#datapolling').DataTable();
        $('#datahubungi').DataTable();
        $('#dataalbum').DataTable();
        $('#datagalerifoto').DataTable();
        $('#datavideo').DataTable();
        $('#datadownload').DataTable();
        $('#datappid').DataTable();
        $('#datasitus').DataTable();
		
		//Datepicker
		$('#tgl_mulai').daterangepicker({singleDatePicker: true,format: 'DD/MM/YYYY', "opens": "left"});
		$('#tgl_selesai').daterangepicker({singleDatePicker: true,format: 'DD/MM/YYYY', "opens": "left"});
		
		$(".select2").select2();
		
		$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
		
		CKEDITOR.replace('isi_<?php echo $_GET['module']; ?>');
      });
    </script>
  </body>
</html>
<?php
}
?>