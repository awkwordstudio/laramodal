<div class="modal {{$laramodal->getOption('animation')? 'fade':''}}" id="{{$laramodal->getOption('id')}}" tabindex="-1" role="dialog" aria-labelledby="{{$laramodal->getOption('id')}}_label">
	<div class="modal-dialog modal-{{$laramodal->getOption('size')}}" role="document">

		<div class="modal-content">

			@if( $__env->yieldContent('modal-content') )
				@yield('modal-content')
			@else


				@if($laramodal->getOption('title'))
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" >{{$laramodal->getOption('title')}}</h4>
					</div>
				@endif
				
				<div class="modal-body">
					@yield('modal-body')
				</div>
				
				<div class="modal-footer">
					@if($laramodal->getOption('dismiss'))
						<button type="button" class="btn btn-default" data-dismiss="modal">@lang('modal.close')</button>
					@endif

					@yield('modal-footer')

				</div>
			@endif
		</div>

	</div>
</div>
