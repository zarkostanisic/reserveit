<template>
	<div>
		<div class="row">
			<div class="col-sm-12 col-md-6">
				<label>Show 
					<select class="form-control-sm" v-model="perpage" @change="getUsers">
						<option value="10">10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
					</select> entries
				</label>
			</div>
			<div class="col-sm-12 col-md-6">
					<!-- <label>Search:</label>
					<input type="search" class="form-control"> -->
			</div>
		</div>
		<table class="table table-responsive m-table table-bordered">
			<thead>
				<tr>
					<th>Id</th>
					<th>Photo</th>
					<th>Full Name</th>
					<th>Company Name</th>
					<th>Username</th>
					<th>Status</th>
					<th>Type</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="user in users.data">
					<th scope="row">{{ user.id }}</th>
					<td>
						<img src="photo/male.png" width="80" height="80">
					</td>
					<td>{{ user.name}}</td>
					<td>Company</td>
					<td>{{ user.email }}</td>
					<td>
						<span class="m-badge m-badge--brand m-badge--wide">Pending</span>
					</td>
					<td>{{ user.role }}</td>
				</tr>
			</tbody>
		</table>
		<pagination :data="users" @pagination-change-page="getUsers"></pagination>
	</div>
</template>

<script>
	export default {

		data() {
			return {
				users: {},
				perpage: 25
			}
		},

		mounted() {
			this.getUsers();
		},

		methods: {
			getUsers(page = 1) {
				axios.get('/api/users?page=' + page + '&perpage=' + this.perpage)
				.then(response => {
					this.users = response.data;
				});
			}
		}

	}
</script>