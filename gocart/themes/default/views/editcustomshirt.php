<?php include('header.php');?>

<?php 
 $segments = $this->uri->total_segments();
        $base_url = $this->uri->segment_array();
        if(!$segments && !$base_url)
        {
            ?>
<?php } ?>


</div>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.1.0/fabric.all.min.js" ></script> 
<!--<script src="<?php echo base_url('fabric/dist/fabric.js'); ?>"></script>-->

<div class="container mainCont" style="min-height: 555px;">
  <br />
  <div class="row">
    <div class="col-md-4">
      <div class="categoryPanel">
        <div class="side-col">
            <table class="table">
			
			<tr>
				<td>
					<select id="changeShirt" class="form-control">
						<option value="">-Choose Shirt Color-</option>
						<option value="red">Red</option>
						<option value="blue">Blue</option>
						<option value="green">Green</option>
						<option value="black">Black</option>
						<option value="white">White</option>
						<option value="yellow">Yellow</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<input type="file" id="imgLoader" name="imgLoader" class="form-control" />
				</td>
			</tr>
			<tr>
				<td>
					<select id="changeColor" class="form-control">
						<option value="">-Choose Color-</option>
						<option value="red">Red</option>
						<option value="blue">Blue</option>
						<option value="green">Green</option>
						<option value="black">Black</option>
						<option value="white">White</option>
						<option value="yellow">Yellow</option>
					</select>
				</td>
			</tr>
             <tr>
				<td><input type="text" id="text" class="form-control" placeholder="Insert Text" /> <button class="btn btn-primary" id="addText">Add</button></td>
			 </tr>
			 <tr>
				<td>
				<select class="form-control" id="shape">
					<option value="">-Select Shape-</option>
					<option value="circle">Circle</option>
					<option value="triangle">Triangle</option>
					<option value="square">Square</option>
				</select>
				<button class="btn btn-danger" id="addShape">Add</button></td>
			 </tr>
			 <tr>
				<td><button class="btn btn-danger" id="deleteObj">Remove Selected</button><button class="btn btn-danger" id="deleteAll">Remove All</button></td>
			 </tr>
			 <tr>
				<td>
				<img src="<?php echo base_url('assets/img/ajax-loader.gif'); ?>" style="display:none;" class="loader" />
				<p class="order_number"></p>
				<input type="hidden" id="elemCount" value="<?php echo $content->customobj; ?>" /><input type="text" id="qty" placeholder="Quantity" value="<?php echo $content->customqty; ?>" /> <button id="generate" class="btn btn-info">Update</button></td>
			 </tr>
            </table><br />
		
          </div> <!-- side-col -->
      </div>
    </div>
    <div class="col-md-8">
       <div class="row">
		<canvas id="tshirt" style="border:1px solid black; background: white;" height="700" width="700"></canvas>
		
		<script>
			$(function(){
				
				var canvas = new fabric.Canvas('tshirt');
				var img = new Image();
				
				
				img.onload = function(){
				   canvas.setBackgroundImage(img.src, canvas.renderAll.bind(canvas), {
							originX: 'left',
							originY: 'top',
							left: 0,
							top: 0
						});
				};
				img.src = "<?php echo theme_img('white.jpg'); ?>"; 
				canvas.loadFromJSON('<?php echo $content->customdata; ?>');
				$('#addText').click(function(){
					var text = $('#text').val();
					var value = new fabric.Text( text, {
						left: canvas.getWidth() / 2,
						top: canvas.getHeight() / 2,
						fontFamily: 'Arial'						
					});
					canvas.add(value);
					countAdd();
					 $('#text').val('');
				});
				
				$('#imgLoader').change(function(){
					var file_data = $(this).prop('files')[0];
					var form_data = new FormData();
					form_data.append('file', file_data);
					$.ajax({
						url: '<?php echo base_url('cart/uploadimg'); ?>',
						dataType: 'text',
						cache: false,
						contentType: false,
						processData: false,
						data: form_data,                         
						type: 'post',
						success: function(file_name){
							var imgUrl = '<?php echo base_url('uploads'); ?>/'+file_name;
							
							fabric.Image.fromURL(imgUrl, function (oImg) {
							canvas.add(oImg);
							canvas.renderAll();
							}, {"left": 300, "top": 300, "scaleX": 0.25, "scaleY": 0.25});
							$(this).val('');
							countAdd();
						}
					 });
				});
				
				$('#changeShirt').change(function(){
					var text = $(this).val();
					if(text == 'red'){
						img.src = "<?php echo theme_img('red.jpg'); ?>"; 
					}
					else if(text == 'blue'){
						img.src = "<?php echo theme_img('blue.jpg'); ?>"; 
					}
					else if(text == 'yellow'){
						img.src = "<?php echo theme_img('yellow.jpg'); ?>";
					}
					else if(text == 'black'){
						img.src = "<?php echo theme_img('black.jpg'); ?>";
					}
					else if(text == 'green'){
						img.src = "<?php echo theme_img('green.jpg'); ?>";
					}
					else{
						img.src = "<?php echo theme_img('white.jpg'); ?>";
					}
					canvas.setBackgroundImage(img.src, canvas.renderAll.bind(canvas), {
						originX: 'left',
						originY: 'top',
						left: 0,
						top: 0
					});
					
				});
				$('#changeColor').change(function(){
					var cv = $(this).val();
					canvas.getActiveObject().set("fill", cv);
					canvas.renderAll();

				});
				$('#addShape').click(function(){
					var selectedShape = $('#shape').val();
					var shape;
					if(selectedShape == 'square'){
						shape = new fabric.Rect({
							left: 100,
							top: 100,
							width: 100,
							height: 100,
							fill: 'green',
							padding: 10
						  });
						  
					}
					else if(selectedShape == 'circle'){
						shape = new fabric.Circle({
							radius: 20, fill: 'green', left: 100, top: 100
						  });
					}
					else if(selectedShape == 'triangle'){
						shape = new fabric.Triangle({
							fill: 'green',
							left: 200,
							top: 200
						  });
					}
					
					canvas.add(shape);
					countAdd();
				});
				$('#deleteObj').click(function(){
					if(confirm('Are you sure')){
						canvas.getActiveObject().remove();
						countMinus();
					}
				});
				$('#deleteAll').click(function(){
					if(confirm('Are you sure')){
						canvas.clear();
						$('#elemCount').val(0);
					}
				});
				
				$('#generate').click(function(){
					
					var xx = JSON.stringify(canvas);
					var qty = $('#qty').val();
					var count = $('#elemCount').val();
					count = parseInt(count);
				
					
					price = 200;
					if(count > 5){
						price = 300;
					}
					$.ajax({
						url: '<?php echo base_url('cart/save_custom/'.$content->id); ?>',
						data: 'data='+xx+'&qty='+qty+'&price='+price,
						type: 'POST',
						success: function(data){
							$('.loader').hide();
							$('.order_number').html('Order successfully updated.');
						},
						beforeSend: function(){
							$('.loader').show();
						}
					});
					
					//alert(xx);
				});
				
				function countAdd(){
					var count = $('#elemCount').val();
					count = parseInt(count);
					count += 1;
					$('#elemCount').val(count);
				}

				function countMinus(){
					var count = $('#elemCount').val();
					count = parseInt(count);
					count -= 1;
					$('#elemCount').val(count);
				}
				
				function dataURItoBlob(dataURI) {
					// convert base64/URLEncoded data component to raw binary data held in a string
					var byteString;
					if (dataURI.split(',')[0].indexOf('base64') >= 0)
						byteString = atob(dataURI.split(',')[1]);
					else
						byteString = unescape(dataURI.split(',')[1]);

					// separate out the mime component
					var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

					// write the bytes of the string to a typed array
					var ia = new Uint8Array(byteString.length);
					for (var i = 0; i < byteString.length; i++) {
						ia[i] = byteString.charCodeAt(i);
					}

					return new Blob([ia], {type:mimeString});
				}
				function download(url,name){
				// make the link. set the href and download. emulate dom click
				  $('<a>').attr({href:url,download:name})[0].click();
				}
				function downloadFabric(canvasx,name){
				//  convert the canvas to a data url and download it.
				  download(canvasx.toDataURL(),name+'.png');
				}
				var json_value = '';
			});
		</script>
	   </div>

    </div>	
  </div>
  
  
  
  <div class="row">
    
  </div><!-- row -->


</div> <!-- container -->


<?php include('footer.php'); ?>