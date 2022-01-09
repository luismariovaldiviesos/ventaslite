<script>
	document.addEventListener('DOMContentLoaded', function() {
		
		window.livewire.on('scan-ok', Msg => {			
			noty(Msg)
		})

		window.livewire.on('scan-notfound', Msg => {			
			noty(Msg, 2)
			doAction()
		})

		window.livewire.on('no-stock', Msg => {			
			noty(Msg, 2)
		})

		window.livewire.on('sale-ok', Msg => {	
			console.log('sale-ok')	
		//@this.printTicket(Msg)		
		noty(Msg)			
	    })

		window.livewire.on('sale-error', Msg => {			
			noty(Msg, 2)
		})

		window.livewire.on('print-ticket', info => {					
			window.open("print://" + info,  '_self').close()
		})
		window.livewire.on('print-last-id', saleId => {					
			window.open("print://" + saleId,  '_self').close()
		})
		

	})
</script>