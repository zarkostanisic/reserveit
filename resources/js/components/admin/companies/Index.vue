<template>
	<div> 
		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							{{ trans.get('companies.list') }}
						</h3>
					</div>
				</div>
				<div class="m-portlet__head-tools">
					<ul class="m-portlet__nav">
						<li class="m-portlet__nav-item">
							<button @click.prevent="createCompany" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--air" data-toggle="modal" data-target="#m_modal_create_company">
								<span>
									<i class="la la-plus"></i>
									<span>{{ trans.get('companies.singular') }}</span>
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

							<select class="form-control form-control-sm custom-select custom-select-sm" v-model="perpage" @change="getCompanies" :disabled="loading">
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select>
						</label>

						<label class="col-sm-12 col-md-2">
							{{ trans.get('universal.name') }} 

							<input type="text" 
								class="form-control form-control-sm" v-bind:value="name" 
								@input="name = $event.target.value"
								@keyup="searchByName()"
								>
						</label>
					</div>
				</div>
				<table class="table table-responsive m-table table-bordered">
					<thead>
						<tr>
							<th>{{ trans.get('universal.id') }}</th>
							<th>{{ trans.get('universal.logo') }}</th>
							<th>{{ trans.get('universal.name') }}</th>
							<th>{{ trans.get('universal.city') }}</th>
							<th>{{ trans.get('universal.quarter') }}</th>
							<th>{{ trans.get('universal.status') }}</th>
							<th>{{ trans.get('universal.actions') }}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="company, key in companies.data">
							<th scope="row">{{ company.id }}</th>
							<td>
								<img :src="company.logo" width="80" height="80">
							</td>
							<td>{{ company.name }}</td>
							<td>{{ company.city }}</td>
							<td>{{ company.quarter != '' ? company.quarter : '-' }}</td>
							<td>
								<span v-if="company.deleted" class="m-badge m-badge--danger m-badge--wide">	
									{{ trans.get('universal.deleted') }}
								</span>
								<div v-else>
									<span class="m-badge m-badge--success m-badge--wide">
										{{ trans.get('universal.active') }}
									</span>
								</div>
							</td>
							<td>
								<div class="m-stack m-stack--ver m-stack--general" style="width: 160px">
									<div class="m-stack__item">
										<button
											type="button" 
											class="btn btn-outline-info" 
											data-toggle="modal" 
											data-target="#m_modal_create_company"
											@click="editCompany(company)">
											{{ trans.get('universal.edit') }}
										</button>
									</div>

									<div class="m-stack__item">

										<button type="button" class="btn" 
											v-if="$gate.isAdmin()"
											v-bind:class="{ 'btn-outline-danger': !company.deleted, 'btn-outline-success': company.deleted}" 
										 	@click="deleteCompany(company.id, key)">
											{{ company.deleted ? trans.get('universal.restore') : trans.get('universal.delete') }}
										</button>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

				<pagination :limit="3" :data="companies" @pagination-change-page="getCompanies" align="right"></pagination>
			</div>

			<BlockUI v-if="loading">
			  <div class="m-loader m-loader--brand" style="width: 30px; display: inline-block;">
			  </div>
			</BlockUI>

			<admin-companies-create :geos="geos"></admin-companies-create>
		</div>
	</div>
</template>

<script>
	import AdminCompaniesCreate from './Create'	
	let timeout = null;

	export default {
		props: ['geos'],
		components: {
		    AdminCompaniesCreate
		},
		data() {
			return {
				companies: {},
				perpage: 25,
				loading: false,
				name: ''
			}
		},
		mounted() {
			this.getCompanies();

			this.$on('company_created', (company) => {
				// this.companies.data.unshift(company);
				window.noty(this.trans.get('universal.success'), 'success');
			});

			this.$on('company_updated', (company) => {
				let companyIndex = this.companies.data.findIndex(c => {
					return company.id == c.id;
				});

				this.companies.data.splice(companyIndex, 1, company);

				window.noty(this.trans.get('universal.success'), 'success');
			});
		},
		methods: {
			getCompanies(page = 1) {
				this.loading = true;

				var ajax_url = '/api/companies?page=' + page 
				ajax_url += '&perpage=' + this.perpage;
				if(this.name != '') ajax_url += '&name=' + this.name;

				axios.get(ajax_url)
				.then(response => {
					$(document).scrollTop(0);
					this.loading = false;

					this.companies = response.data;
				});
			},

			createCompany(){
				this.$emit('create_company');
			},

			editCompany(company){
				this.$emit('edit_company', {company});
			},

			deleteCompany(id, key) {
				if(confirm(this.trans.get('universal.confirm'))){
					this.loading = true;

					var ajax_url = '/api/companies/' + id;

					axios.delete(ajax_url)
					.then(response => {
						this.loading = false;

						this.companies.data.splice(key, 1, response.data.data);

						window.noty(this.trans.get('universal.success'), 'success');
					});
				}
			},
			searchByName(){
				clearTimeout(timeout);

				timeout = setTimeout(() => {
					this.getCompanies();
				}, 500);
			}
		}

	}
</script>