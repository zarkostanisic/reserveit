<template>
	<div> 
		<div class="row">
			<div class="col-sm-12 col-md-4">
				<label>
					{{ trans.get('universal.show') }} 

					<select class="form-control-sm" v-model="perpage" @change="getUsers" :disabled="loading">
						<option value="10">10</option>
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="100">100</option>
					</select>
				</label>
			</div>
			<div class="col-sm-12 col-md-4">
				<label>{{ trans.get('universal.role') }}
					<select class="form-control-sm" v-model="role_id" @change="getUsers" :disabled="loading">
						<option value="0">
							{{ trans.get('universal.choose') }}
						</option>
						<option v-for="role in roles" :value="role.id">
							{{ trans.get('universal.' + role.name) }}
						</option>
					</select>
				</label>
			</div>

			<div class="col-sm-12 col-md-4" v-if="$gate.isAdmin()">
				<label> {{ trans.get('companies.singular') }}
					<select class="form-control-sm" v-model="company_id" @change="getUsers" :disabled="loading">
						<option value="0">
							{{ trans.get('universal.choose') }}
						</option>
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
					<th>{{ trans.get('universal.id') }}</th>
					<th>{{ trans.get('universal.photo') }}</th>
					<th>{{ trans.get('universal.full_name') }}</th>
					<th v-if="user_company == 0">{{ trans.get('companies.singular') }}</th>
					<th>{{ trans.get('universal.username') }}</th>
					<th>{{ trans.get('universal.status') }}</th>
					<th>{{ trans.get('universal.role') }}</th>
					<th>{{ trans.get('universal.actions') }}</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="user, key in users.data">
					<th scope="row">{{ user.id }}</th>
					<td>
						<img src="photo/male.png" width="80" height="80">
					</td>
					<td>{{ user.name }}</td>
					<td v-if="user_company == 0">{{ user.company }}</td>
					<td>{{ user.email }}</td>
					<td>
						<span v-if="user.deleted" class="m-badge m-badge--danger m-badge--wide">	
							{{ trans.get('universal.deleted') }}
						</span>
						<div v-else>
							<span class="m-badge m-badge--success m-badge--wide">
								{{ trans.get('universal.active') }}
							</span>
						</div>
					</td>
					<td>{{ trans.get('universal.' + user.role) }}</td>
					<td>
						<button type="button" class="btn" 
							v-if="user.id > 1 && $gate.isAdmin()"
							v-bind:class="{ 'btn-danger': !user.deleted, 'btn-success': user.deleted}" 
						 	@click="deleteUser(user.id, key)">
							{{ user.deleted ? trans.get('universal.restore') : trans.get('universal.delete') }}
						</button>
					</td>
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
		props: ['roles', 'companies', 'user_company'],
		data() {
			return {
				users: {},
				perpage: 25,
				role_id: 0,
				company_id: 0,
				loading: false
			}
		},

		mounted() {
			this.getUsers();
			console.log(this.$gate.isAdmin());
		},

		methods: {
			getUsers(page = 1) {
				this.loading = true;

				var ajax_url = '/api/users?page=' + page 
				ajax_url += '&perpage=' + this.perpage;
				ajax_url += '&role_id=' + this.role_id;
				ajax_url += '&company_id=' + (this.user_company > 0 ? this.user_company : this.company_id);

				axios.get(ajax_url)
				.then(response => {
					$(document).scrollTop(0);
					this.loading = false;

					this.users = response.data;
				});
			},

			deleteUser(id, key) {
				if(confirm(this.trans.get('universal.confirm'))){
					this.loading = true;

					var ajax_url = '/api/users/' + id;

					axios.delete(ajax_url)
					.then(response => {
						this.loading = false;

						this.users.data.splice(key, 1, response.data.data);
					});
				}
			}
		}

	}
</script>