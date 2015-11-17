</div>
	<div id="footer">
		&copy; - <?php echo date('Y', time()); ?>
		<a href="https://rexcode.github.io" target="_blank" title="Github profile">Rexcode</a>&nbsp;
    <a href="https://github.com/rexcode/Photo-Gallery-Project" target="_blank"><img src="../images/github10.png" alt="Github icon" title="Github repository of this project " width="12px" height="12px"></a>
  <br><br>
	<br><br>
	</div>

	<?php if (isset($database)) { $database->close_connection(); } ?>
		
	<script src="../js/jquery-1.11.3.js"></script>
	<script src="../js/jquery-2.1.4.js"></script>
	<script src="../js/jquery.adipoli.min.js"></script>
	<script src="../js/jquery.contenthover.js"></script>
	<script src= "../js/script.js"></script>
</body>
</html>