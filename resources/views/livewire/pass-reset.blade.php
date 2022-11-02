<div>
    <x-jet-responsive-nav-link wire:click="$set('open',true)" class="text-muted me-3 text-decoration-none" style="cursor: pointer">
        <i class="bi bi-wifi-off"></i>
        {{ __('Problemas de Acceso') }}
    </x-jet-responsive-nav-link>
    
    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title">
            {{__('No se puede acceder al sistema')}}
        </x-slot>

        <x-slot name="content">
            {{__('Si olvido su contraseña o su cuenta ha sido desactivada, favor de contactar al área de Sistemas para que le sea proporcionado o bien, renovado su acceso al sistema. Gracias.')}}
        </x-slot>

        <x-slot name="footer">
            <x-jet-danger-button wire:click="$set('open',false)">
                {{__('Entendido')}}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
