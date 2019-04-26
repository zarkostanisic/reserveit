<template>
	<div> 
		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							{{ trans.get('users.list') }}
						</h3>
					</div>
				</div>
				<div class="m-portlet__head-tools">
					<ul class="m-portlet__nav">
						<li class="m-portlet__nav-item">
							<a @click="create = !create" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--air">
								<span>
									<i class="la la-plus"></i>
									<span>{{ trans.get('users.singular') }}</span>
								</span>
							</a>
						</li>
						<li class="m-portlet__nav-item"></li>
					
					</ul>
				</div>
			</div>
			<div class="m-portlet__body">
				<div class="row" v-if="create">
					<div class="col-sm-12 col-md-4">
						<admin-users-create :roles="roles" :companies="companies"></admin-users-create>
					</div>
				</div>
				<div v-else>
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
				</div>

				<BlockUI v-if="loading">
				  <div class="m-loader m-loader--brand" style="width: 30px; display: inline-block;">
				  </div>
				</BlockUI>
			</div>
		</div>
	</div>
</template>

<script>
	import AdminUsersCreate from './Create'	

	export default {
		props: ['roles', 'companies'],
		components: {
		    AdminUsersCreate
		},
		data() {
			return {
				create: false,
				users: {},
				perpage: 25,
				role_id: 0,
				company_id: 0,
				loading: false,
				user_company: this.$gate.user.company_id
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