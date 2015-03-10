<script type="text/javascript">

    $(document).ready(function() {
        document.title = "<?php echo $pageTitle;?>";
		//Create the scroll pane, if present
        var scrollPane=$('.scroll-pane');
		if(scrollPane.length > 0){
			scrollPane.jScrollPane({showArrows: true});
		}

    });
</script>	
	<table style="width:100%;margin-top:30px;">
			<tr>
				<td style="text-align: center;font-size:0.6em;">&copy;Software Ltd.</td>
			</tr>
		</table>
	</body>
</html>
