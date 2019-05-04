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
							<button @click.prevent="createUser" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--air" data-toggle="modal" data-target="#m_modal_create_user">
								<span>
									<i class="la la-plus"></i>
									<span>{{ trans.get('users.singular') }}</span>
								</span>
							</button>
						</li>
						<li class="m-portlet__nav-item"></li>
					
					</ul>
				</div>
			</div>

			<div class="m-portlet__body">
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<label class="col-sm-12 col-md-1">
							{{ trans.get('universal.show') }} 

							<select class="form-control form-control-sm custom-select custom-select-sm" v-model="perpage" @change="getAllWithFilter" :disabled="loading">
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
						</label>

						<label class="col-sm-12 col-md-2">{{ trans.get('universal.role') }}
							<select class="form-control form-control-sm custom-select custom-select-sm" v-model="role_id" @change="getAllWithFilter" :disabled="loading">
								<option value="0">
									{{ trans.get('universal.choose') }}
								</option>
								<option v-for="role in roles" :value="role.id">
									{{ trans.get('universal.' + role.name) }}
								</option>
							</select>
						</label>

						<label class="col-sm-12 col-md-2"
							v-if="$gate.isAdmin() && role_id != 1"
							> {{ trans.get('companies.singular') }}
							<select class="form-control form-control-sm custom-select custom-select-sm" v-model="company_id" @change="getAllWithFilter" :disabled="loading">
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
							<th 
								:class="orderActive('id')" 
								@click="orderBy('id')">{{ trans.get('universal.id') }}</th>
							<th>{{ trans.get('universal.photo') }}</th>
							<th 
								:class="orderActive('name')" 
								@click="orderBy('name')">{{ trans.get('universal.full_name') }}</th>
							<th 
								:class="orderActive('companies.name')"
								@click="orderBy('companies.name')" v-if="user_company_id == 0">{{ trans.get('companies.singular') }}</th>
							<th 
								:class="orderActive('email')"
								@click="orderBy('email')">{{ trans.get('universal.email') }}</th>
							<th>{{ trans.get('universal.address') }}</th>
							<th>{{ trans.get('universal.phone') }}</th>
							<th>{{ trans.get('universal.status') }}</th>
							<th 
								:class="orderActive('roles.name')"
								@click="orderBy('roles.name')">{{ trans.get('universal.role') }}</th>
							<th>{{ trans.get('universal.created_at') }}</th>
							<th>{{ trans.get('universal.actions') }}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="user, key in users.data">
							<th scope="row">{{ user.id }}</th>
							<td>
								<img :src="user.photo" width="80" height="80">
							</td>
							<td>{{ user.name }}</td>
							<td v-if="user_company_id == 0">
								{{ user.role_id == 1 ? '-' : user.company }}
							</td>
							<td>{{ user.email }}</td>
							<td>{{ user.address }}</td>
							<td>{{ user.phone }}</td>
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
							<td width="100">{{ getDateWithFormat(user.created_at, 'DD-MM-YYYY') }}</td>
							<td>
								<div class="m-stack m-stack--ver m-stack--general" style="width: 160px">
									<div class="m-stack__item">
													
										<button v-if="user.id > 1"
											type="button" 
											class="btn btn-outline-info" 
											data-toggle="modal" 
											data-target="#m_modal_create_user"
											@click="editUser(user)">
											{{ trans.get('universal.edit') }}
										</button>
									</div>

									<div class="m-stack__item">
										<button type="button" class="btn" 
											v-if="user.id > 1 && $gate.isAdmin()"
											v-bind:class="{ 'btn-outline-danger': !user.deleted, 'btn-outline-success': user.deleted}" 
										 	@click="deleteUser(user.id, key)">
											{{ user.deleted ? trans.get('universal.restore') : trans.get('universal.delete') }}
										</button>

									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

				<pagination :limit="3" :data="users" @pagination-change-page="getAllWithFilter" align="right"></pagination>
			</div>

			<BlockUI v-if="loading">
			  <div class="m-loader m-loader--brand" style="width: 30px; display: inline-block;">
			  </div>
			</BlockUI>

			<admin-users-create :roles="roles" :companies="companies"></admin-users-create>
		</div>
	</div>
</template>

<script>
	import AdminUsersCreate from './Create'
	import {getDateWithFormat} from '../../../Helpers'
	import {orderBy} from '../../../Helpers'
	import {orderActive} from '../../../Helpers'

	export default {
		props: ['roles', 'companies'],
		components: {
		    AdminUsersCreate
		},
		data() {
			return {
				users: {},
				perpage: 25,
				orderField: 'id',
				order: 'asc',
				role_id: 0,
				company_id: 0,
				loading: false,
				user_company_id: this.$gate.getCompanyId()
			}
		},
		mounted() {
			this.getAllWithFilter();

			this.$on('user_created', (user) => {
				// this.users.data.unshift(user);
				window.noty(this.trans.get('universal.success'), 'success');
			});

			this.$on('user_updated', (user) => {
				let userIndex = this.users.data.findIndex(u => {
					return user.id == u.id;
				});

				this.users.data.splice(userIndex, 1, user);

				window.noty(this.trans.get('universal.success'), 'success');
			});
		},
		methods: {
			getAllWithFilter(page = 1) {
				this.loading = true;
				if(this.user_company_id > 0) this.company_id = this.user_company_id;
				if(this.role_id == 1) this.company_id = 0;

				var ajax_url = '/api/users?page=' + page 
				ajax_url += '&perpage=' + this.perpage;
				ajax_url += '&orderBy=' + this.orderField
				ajax_url += '&order=' + this.order,
				ajax_url += '&role_id=' + this.role_id;
				ajax_url += '&company_id=' + this.company_id;

				axios.get(ajax_url)
				.then(response => {
					$(document).scrollTop(0);
					this.loading = false;

					this.users = response.data;
				});
			},

			createUser(){
				this.$emit('create_user');
			},

			editUser(user){
				this.$emit('edit_user', {user});
			},

			deleteUser(id, key) {
				if(confirm(this.trans.get('universal.confirm'))){
					this.loading = true;

					var ajax_url = '/api/users/' + id;

					axios.delete(ajax_url)
					.then(response => {
						this.loading = false;

						this.users.data.splice(key, 1, response.data.data);

						window.noty(this.trans.get('universal.success'), 'success');
					});
				}
			},
			getDateWithFormat,
			orderBy,
			orderActive
		}

	}
</script>