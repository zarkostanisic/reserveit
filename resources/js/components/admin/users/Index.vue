<template>
	<div> 
		<div class="row">
			<div class="col-sm-12 col-md-4">
				<label>{{ trans.get('universal.show') }} 
					<select class="form-control-sm" v-model="perpage" @change="getUsers" :disabled="loading">
						<option value="10">10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
					</select>
				</label>
			</div>
			<div class="col-sm-12 col-md-4">
				<label>Role
					<select class="form-control-sm" v-model="role_id" @change="getUsers" :disabled="loading">
						<option value="-1">All</option>
						<option v-for="role in roles" :value="role.id">
							{{ role.name }}
						</option>
					</select>
				</label>
			</div>
			<div class="col-sm-12 col-md-4">
				<label> {{ trans.get('companies.singular') }}
					<select class="form-control-sm" v-model="company_id" @change="getUsers" :disabled="loading">
						<option value="-1">All</option>
						<option v-for="company in companies" :value="company.id">
							{{ company.name }}
						</option>
					</select>

				</label>
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
				<tr v-if="loading">
					<td colspan="7">
						<div class="m-loader" style="width: 30px; display: inline-block;"></div>
					</td>
				</tr>
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

		<BlockUI v-if="loading">
		  <div class="m-loader m-loader--brand" style="width: 30px; display: inline-block;">
		  </div>
		</BlockUI>
	</div>
</template>

<script>
	export default {
		props: ['roles', 'companies'],
		data() {
			return {
				users: {},
				perpage: 25,
				role_id: -1,
				company_id: -1,
				loading: false
			}
		},

		mounted() {
			this.getUsers();
		},

		methods: {
			getUsers(page = 1) {
				this.loading = true;

				var ajax_url = '/api/users?page=' + page 
				ajax_url += '&perpage=' + this.perpage;
				ajax_url += '&role_id=' + this.role_id;
				ajax_url += '&company_id=' + this.company_id;

				axios.get(ajax_url)
				.then(response => {
					this.loading = false;

					this.users = response.data;
				});
			}
		}

	}
</script>