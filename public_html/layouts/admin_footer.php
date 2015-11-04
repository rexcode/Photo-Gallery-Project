</div>
	<div id="footer">
		&copy; - <?php echo date('Y', time()); ?>
		<a href="https://github.com/rexcode">Rexcode</a> - Vicky Patel.
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