<div class="row layout-top-spacing">
	<div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
		@if($action == 1)

		<div class="widget-content-area br-4">
			<div class="widget-header">
				<div class="row">
					<div class="col-xl-12 text-center">
						<h4><b>Viajes y Cotizaciones</b></h4>
					</div>
				</div>
			</div>
			 @include('common.search', ['create' => 'cotizaciones_create'])
			@include('common.alerts')
			<div class="table-responsive">			
				<table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
					<thead>
						<tr>
							<th class="text-center">FOLIO</th>
							<th class="text-center">CLIENTE</th>
							<th class="text-center">INFO</th>
							<th class="text-center">SALIDA</th>
							<th class="text-center">REGRESO</th>
							<th class="text-center">PERSONAS</th>
							<th class="text-center">TOTAL</th>
							<th class="text-center">ANTICIPO</th>
							<th class="text-center">DEBE</th>
							<th class="text-center">ESTATUS</th>
							<th class="text-center">ACCIONES</th>
						</tr>
					</thead>
					<tbody>
						@foreach($info as $r)
						<tr>

							<td class="text-center"><p class="mb-0">{{$r->id}}</p></td>
							<td class="text-center">{{$r->titular}}</td>
							<td class="text-center">{{$r->descripcion}}</td>
							<td class="text-center">{{$r->salida}}</td>
							<td class="text-center">{{$r->regreso}}</td>
							<td class="text-center">
								<span><b>Adultos</b>: {{$r->adultos}}</span>
								<br>
								<span><b>Menores</b>: {{$r->menores}}</span>
								<br>
								<span><b>Infantes</b>: {{$r->infantes}}</span>
							</td>
							<td class="text-center">${{number_format($r->total,2)}}</td>
							<td class="text-center">${{number_format($r->anticipo,2)}}</td>
							<td class="text-center">${{number_format($r->debe,2)}}</td>
							<td class="text-center">{{$r->estatus}}</td>
							<td class="text-center" class="text-center">
								<ul class="table-controls">

									<li>
										<a href="javascript:void(0);" onclick="showHistory('{{$r->id}}')" data-toggle="tooltip" data-placement="top" title="Abonar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></a>
									</li>
									@if($r->estatus !='Pagada')
									<li>
										<a href="javascript:void(0);" onclick="modalPays('{{$r->id}}')" data-toggle="tooltip" data-placement="top" title="Abonar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></a>
									</li>
									@endif

									<li>
										<a href="javascript:void(0);" wire:click="edit({{$r->id}})" data-toggle="tooltip" data-placement="top" title="Editar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
									</li>
									@if($r->estatus !='Pagada')
									
								@endif

							</ul>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			{{$info->links()}}
		</div>
	</div>
	<input type="hidden" value="0" id="coti_id">

	@elseif($action == 2)
	@include('livewire.cotizaciones.form')
	@endif

	<!--modal-->
	<div class="modal fade" id="modalHistorial" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" >Historial de Pagos</h5>
				</div>            
				<div class="modal-body">
					<!--tabla-->
					<div class="row">
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
								<thead>                            		
									<tr>
										<th class="border-top-0 text-center" width="15%">Folio</th>
										<th class="border-top-0 text-center" width="70%">Monto</th>
										<th class="border-top-0 text-center" width="15%">Fecha</th>                    
									</tr>
								</thead>
								<tbody>
									@if($pagos)
									@foreach($pagos as $p)
									<tr>
										<td class="text-truncate text-center">{{$p->id}}</td>
										<td class="text-truncate text-center">${{number_format($p->monto,2)}}</td>
										<td class="text-truncate text-center">{{\Carbon\Carbon::parse($p->created_at)->format('d/m/Y')}}</td>
									</tr>   
									@endforeach                                         
									@endif
								</tbody>
								<tfoot>
									<tr>
										<td colspan="2" class="text-right">
											@if($pagos)
											<h6><b>Total</b>: ${{number_format($pagos->sum('monto'),2)}}</h6>
											@endif
										</td>
									</tr>
								</tfoot>
							</table>

						</div>
					</div>
					<!--tabla-->
				</div>
				<div class="modal-footer">
					<button class="btn btn-dark" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	<!--modal abonos -->
	<div class="modal fade" id="modalAbonos" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" >Realizar Pago</h5>
				</div>            
				<div class="modal-body">
					<!--tabla-->
					<div class="row">
						<div class="col">
							<small><b>Ingresa el monto</b></small>
							<input type="number" id="abono" class="form-control"
							wire:keydown.enter="$emit('RegisterPay', $('#coti_id').val(), $('#abono').val() )"
							>
						</div>
					</div>
					<!--tabla-->
				</div>
				<div class="modal-footer">
					<button class="btn btn-dark" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>
					<button type="button" class="btn btn-primary RegisterPay">Guardar</button>
				</div>
			</div>
		</div>
	</div>


</div>

<script src="https://a.kabachnik.info/assets/js/onscan.min.js"></script>


<script type="text/javascript">
	function showHistory(id){
		window.livewire.emit('getPays', id)		
	}
	function modalPays(id){
		$('#coti_id').val(id)
		$('#modalAbonos').modal('show');   
	}


	function Confirm(id)
	{
		let me = this
		swal({
			title: 'CONFIRMAR',
			text: '¿DESEAS ELIMINAR EL REGISTRO?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Aceptar',
			cancelButtonText: 'Cancelar',
			closeOnConfirm: false
		},
		function() {
			console.log('ID', id);
			window.livewire.emit('deleteRow', id)
			toastr.success('info', 'Registro eliminado con éxito')
			swal.close()
		})

	}

	document.addEventListener('DOMContentLoaded', function () {

		window.livewire.on('paysLoaded', infoPays => {
			$('#modalHistorial').modal('show');   
		})
		window.livewire.on('pay-ok', msgText => {
			toastr.success('info', msgText)
			$('#modalAbonos').modal('hide')
		})


		$('body').on('click','.RegisterPay', function() {
			var coti = $('#coti_id').val()
			var monto = $('#abono').val()        
			$('#modalAbonos').modal('hide')
			window.livewire.emit('RegisterPay',coti, monto)
			$('#abono').val('')
		})



})



</script>

<script type="text/javascript">

	if (typeof console  != "undefined") 
    if (typeof console.log != 'undefined')
        console.olog = console.log;
    else
        console.olog = function() {};

	console.log = function(message, error) {
		console.olog(message);
		var oOutput = document.getElementById('consoleTextField');
		if (error){ 
			oOutput.value += "ERROR: " + message + '\n';
		} else {
			oOutput.value += ('> ' + message + '\n');
		}
		oOutput.scrollTop = oOutput.scrollHeight;
	};
	console.error = console.debug = console.info =  console.log;

	window.onerror = function(msg){
			console.log(msg, true);
	}
	
	function initOnScan(){
		
		
		var prop;
		var array;
		var suffixKeyCodes = [];
		var prefixKeyCodes = [];
		
					
		var options = {
			timeBeforeScanTest: 100, 
			avgTimeByChar:30,
			minLength: 6, 
			suffixKeyCodes: suffixKeyCodes,
			prefixKeyCodes: prefixKeyCodes, 
			scanButtonLongPressTime: 500, 
			stopPropagation: false, 
			preventDefault: false,
			reactToPaste: false,
			reactToKeyDown: false,
			singleScanQty: false
		}
		
		if (document.getElementById("iOnComplete").checked){
			options.onScan = function(barcode, qty){
				console.log("[onScan]: Code: " + barcode + " Quantity: " + qty);
			};
		} else {
			options.onScan = function(){};
		}
				
		if (document.getElementById("iOnError").checked){
			options.onScanError = function(err){
				var sFormatedErrorString = "Error Details: {\n";
				for (var i in err){
					sFormatedErrorString += '    ' + i + ': ' + err[i] + ",\n";
				}
				sFormatedErrorString = sFormatedErrorString.trim().replace(/,$/, '') + "\n}";
				console.log("[onScanError]: " + sFormatedErrorString);
			}; 	
		} else {
			options.onScanError = function(){};
		}
		
		
		if (document.getElementById("iOnKeyProcessed").checked){
			options.onKeyProcess = function(sChar, oEvent){
				console.log('[onKeyProcess]: Processed character "' + sChar + '"');
			};
		} else {
			options.onKeyProcess = function(){};
		}
		
		
		if (document.getElementById("iOnKeyDetect").checked){
			options.onKeyDetect = function(iKey, oEvent){
				var oEventProps = ''
					+ 'key:"' + oEvent.key + '", '
					+ 'ctrlKey:' + oEvent.ctrlKey + ', '
					+ 'altKey:' + oEvent.altKey + ', '
					+ 'shiftKey:' + oEvent.shiftKey + ', '
					+ 'metaKey:' + oEvent.metaKey + ', '
					+ 'keyCode:' + oEvent.keyCode + ', '
					+ 'charCode:' + oEvent.charCode + ', ';
				console.log('[onKeyDetect]: Detected key code "' + iKey + '". Event dump: ' + oEventProps);
			};
		} else {
			options.onKeyDetect = function(){};
		}
		
		if (document.getElementById("iIgnoreIfFocusOn").checked){
			document.getElementById("iIgnoreIfFocusOnSelector").removeAttribute("disabled");
			options.ignoreIfFocusOn = document.getElementById("iIgnoreIfFocusOnSelector").value;
		} else {
			options.ignoreIfFocusOn = false;
			document.getElementById("iIgnoreIfFocusOnSelector").disabled = "disabled";
		}
		
		if (document.getElementById("iScanButtonKeyCode").value){
			options.scanButtonKeyCode = parseInt(document.getElementById("iScanButtonKeyCode").value);
		} else {
			options.scanButtonKeyCode = false;
		}
		
		if (document.getElementById("iOnScanButtonLongPressed").checked){
			options.onScanButtonLongPress = function(){
				console.log("[onScanButtonLongPress]: ScanButton has been long-pressed");
			};
		} else {
			options.onScanButtonLongPress = function(){};
		}
		
		if (document.getElementById("iOnPaste").checked){
			options.onPaste = function(sPasteString){
				console.log("[onPaste]: Data has been pasted: " + sPasteString);
			}
		} else {
			options.onPaste = function(){};
		}
							
		if (document.getElementById("iCompleteHandler").checked){
			document.addEventListener('scan', scanHandler);
		} else {
			document.removeEventListener('scan', scanHandler);
		}
		
		if (document.getElementById("iCompleteHandler").checked){
			document.addEventListener('scanError', scanErrorHandler);
		} else {
			document.removeEventListener('scanError', scanErrorHandler);
		}
		
		if (document.getElementById("ikeyCodeMapper").checked){
			options.keyCodeMapper = function (e) {
				var iKeyCode = e.which;
				var sChar = onScan.decodeKeyEvent(e);
				console.log('[keyCodeMapper]: Decoding key code "' + iKeyCode + '" to "' + sChar + '"')
				return sChar;
			}
		}		
		
		try {
			onScan.attachTo(document, options);
			console.log("onScan Started!");
		} catch(e) {
			onScan.setOptions(document, options);
			console.log("onScansettings changed!");
		}
		

	}
	
	function destroyOnScan(){
		console.log("onScan destroyed!");
		onScan.detachFrom(document);	
	}
	
	function clearTextArea(){
		document.getElementById('consoleTextField').value = "";
	}
	
	function scanHandler(e){
		console.log("[scanHandler]: Code: " + e.detail.code);
	}
	
	function scanErrorHandler(e){
		var sFormatedErrorString = "Error Details: {\n";
		for (var i in e.detail){
			sFormatedErrorString += '    ' + i + ': ' + e.detail[i] + ",\n";
		}
		sFormatedErrorString = sFormatedErrorString.trim().replace(/,$/, '') + "\n}";
		console.log("[scanErrorHandler]: " + sFormatedErrorString);
	}
	
	function getonScanSettings(){
		var sFormatedErrorString = "Scanner Settings: \n";
				var aJSONArray = JSON.stringify(onScan.getOptions(document)).split(",");
				for (prop = 0; prop < aJSONArray.length - 1; prop++){
					if (aJSONArray[prop+1][0] == '\"'){
						sFormatedErrorString += aJSONArray[prop] + "," + "\n";
					} else {
						sFormatedErrorString += aJSONArray[prop] + ",";
					}
				}
				sFormatedErrorString += aJSONArray[aJSONArray.length - 1];
				
				console.log(sFormatedErrorString);
		
		
	}
	
	function fireTestInput(){
		var sInput = (document.getElementById("iTestInput").value || '').trim();
		if (sInput.startsWith('[') && sInput.endsWith(']')) {
			onScan.simulate(document, JSON.parse(sInput));
		} else {
			onScan.simulate(document, sInput);
		}
	}
	
	(function(){
		initOnScan();
		document.querySelectorAll("#playground input").forEach(function(oInput){
			if (oInput.type == 'button' || oInput.readonly) {
				return;
			}
			
			oInput.addEventListener('change', function(){
				console.log('onScan configuration updated');
				onScan.detachFrom(document);
				initOnScan();
			});
		});
	})();
</script>
