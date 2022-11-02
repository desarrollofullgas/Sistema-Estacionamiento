<div class="row layout-top-spacing">
	<div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
		@if($action == 1)

		<div class="widget-content-area br-4">
			<div class="widget-header">
				<div class="row">
					<div class="col-xl-12 text-center">
						<h4><b>Cuentas por Pagar</b></h4>
					</div>
				</div>
			</div>
			 @include('common.search', ['create' => 'cuentasxpagar_create'])	
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
					<thead>
						<tr>
							<th class="text-center">FOLIO</th>
							<th class="text-center">OPERADORA</th>
							<th class="text-center">PRECIO ADULTO</th>
							<th class="text-center">PRECIO JUNIOR</th>
							<th class="text-center">PRECIO MENOR</th>
							<th class="text-center">TOTAL</th>
							<th class="text-center">ESTATUS</th>
							<th class="text-center">ABONADO</th>
							<th class="text-center">DEBE</th>							
							<th class="text-center">ACCIONES</th>
						</tr>
					</thead>
					<tbody>
						@foreach($info as $r)
						<tr>

							<td class="text-center"><p class="mb-0">{{$r->id}}</p></td>
							<td class="text-center">{{$r->operadora}}</td>
							<td class="text-center">${{number_format($r->precioadulto,2)}}</td>
							<td class="text-center">${{number_format($r->preciojr,2)}}</td>
							<td class="text-center">${{number_format($r->preciomenor,2)}}</td>							
							<td class="text-center">${{number_format($r->total,2)}}</td>
							<td class="text-center">
								@if($r->estatus == "Pendiente" )
								<span class="text-danger"><strong>{{$r->estatus}}</strong></span>
								@else
								<span class="text-success"><strong>{{$r->estatus}}</strong></span>
								@endif
							</td>
							<td class="text-center">${{number_format($r->abonos()->sum("monto"),2)}}</td>
							<td class="text-center">${{ number_format($r->total - $r->abonos()->sum("monto"),2)  }}</td>
							<td class="text-center" class="text-center">
								<ul class="table-controls">

									<li>
										<a  onclick="showHistory('{{$r->id}}')" data-toggle="tooltip" data-placement="top" title="Abonar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></a>
									</li>
									@if($r->estatus !='Pagado')
									<li>
										<a  onclick="modalPays('{{$r->id}}')" data-toggle="tooltip" data-placement="top" title="Abonar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></a>
									</li>
									@endif

									<li>
										<a  wire:click="edit({{$r->id}})" data-toggle="tooltip" data-placement="top" title="Editar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
									</li>
									
								</ul>
							</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5" class="text-right"><b>ADEUDO TOTAL AL MOMENTO</b>:</td>
							<td colspan="1" class="text-center">${{number_format($sumaTotal,2)}}</td>
							<td colspan="4"></td>
						</tr>
					</tfoot>
				</table>
				{{$info->links()}}
			</div>
		</div>
		<input type="hidden" value="0" id="cta_id">

		@elseif($action == 2)
		@include('livewire.cotizaciones.formcuentas')
		@endif

		<!--modal-->
		<div class="modal fade" id="modalHistorial" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" >Historial de Abonos</h5>
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
								<input type="number" id="abono" min="0" value="0" class="form-control"
								wire:keydown.enter="$emit('RegisterPay', $('#cta_id').val(), $('#abono').val() )"
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
</div>

	<script type="text/javascript">
		function showHistory(id){
			window.livewire.emit('getPays', id)		
		}
		function modalPays(id){
			$('#cta_id').val(id)
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
				$('#abono').val('')
			})


			$('body').on('click','.RegisterPay', function() {
				var cta = $('#cta_id').val()
				var monto = $('#abono').val()       
				if(parseFloat(monto)<=0 )
				{
					toastr.warning('info', 'Ingresa un monto mayor a cero')
					return;
				}
				$('#modalAbonos').modal('hide')
				window.livewire.emit('RegisterPay',cta, monto)
				$('#abono').val('')
				console.log(cta, monto)
			})



		});
	</script>