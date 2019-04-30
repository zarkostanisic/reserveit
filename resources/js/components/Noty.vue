<template></template>
<script>
	import Swal from 'sweetalert2'

	export default{
		created(){
			window.events.$on('notification', (notification, type = 'success') => {
				Swal.fire({
			  		text: notification,
			  		type: type,
				});
			});

		}

	}
</script>