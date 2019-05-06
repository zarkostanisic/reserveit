<template>
	<div>
		<!--begin::Modal-->
		<div class="modal fade" id="m_modal_create_company" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">
							{{ editing ? trans.get('universal.edit') : trans.get('universal.create') }}
						</h5>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form class="m-form m-form--fit m-form--label-align-right" enctype="multipart/form-data">
							<div class="m-form__section m-form__section--first">
								<div class="form-group m-form__group row">
									<label for="name" class="col-lg-2 col-form-label">{{ trans.get('universal.name') }}</label>
									<div class="col-lg-8">
										<input v-model="company.name" type="text" class="form-control m-input" placeholder="" id="name">
										<span v-if="errors.name"class="m-form__help">{{ errors.name[0] }}</span>
									</div>
								</div>

								<div class="form-group m-form__group row">
									<label class="col-lg-2 col-form-label">
										{{ trans.get('universal.category') }}
									</label>
									<div class="col-lg-8">
										<select class="form-control custom-select" id="city_id" 
										v-model="company.category_id" 
										>
											<option value="">{{ trans.get('universal.choose') }}</option>
											<option v-for="category in categories" 
											:value="category.id"
											>
												{{ trans.get('companies.' + category.name ) }}
											</option>
										</select>

										<span v-if="errors.category_id"class="m-form__help">{{ errors.category_id[0] }}</span>
									</div>
								</div>

								<div class="form-group m-form__group row">
									<label class="col-lg-2 col-form-label">
										{{ trans.get('universal.city') }}
									</label>
									<div class="col-lg-8">
										<select class="form-control custom-select" id="city_id" 
										v-model="company.city_id" 
										@change="changeCity()"
										>
											<option value="">{{ trans.get('universal.choose') }}</option>
											<option v-for="geo in geos" 
											:value="geo.id"
											>
												{{ geo.name }}
											</option>
										</select>

										<span v-if="errors.city_id"class="m-form__help">{{ errors.city_id[0] }}</span>
									</div>
								</div>

								<div class="form-group m-form__group row" v-show="quarters.length > 0">
									<label class="col-lg-2 col-form-label">
										{{ trans.get('universal.quarter') }}
									</label>
									<div class="col-lg-8">
										<select class="form-control custom-select" id="quarter_id"
										v-model="company.quarter_id" 
										>
											<option value="0">{{ trans.get('universal.choose') }}</option>
											<option v-for="quarter in quarters" 
											:value="quarter.id"
											>
												{{ quarter.name }}
											</option>
										</select>

									</div>
								</div>

								<div class="form-group m-form__group row">
									<label for="address" class="col-lg-2 col-form-label">{{ trans.get('universal.address') }}</label>
									<div class="col-lg-8">
										<input v-model="company.address" type="text" class="form-control m-input" id="address">
										<span v-if="errors.address"class="m-form__help">{{ errors.address[0] }}</span>
									</div>
								</div>

								<div class="form-group m-form__group row">
									<label for="phone" class="col-lg-2 col-form-label">{{ trans.get('universal.phone') }}</label>
									<div class="col-lg-8">
										<input v-model="company.phone" v-mask="'### #######'" type="text" class="form-control m-input" id="phone">
										<span v-if="errors.phone"class="m-form__help">{{ errors.phone[0] }}</span>
									</div>
								</div>

								<div class="form-group m-form__group row">
									<label for="email" class="col-lg-2 col-form-label">{{ trans.get('universal.email') }}</label>
									<div class="col-lg-8">
										<input v-model="company.email" type="text" class="form-control m-input" placeholder="" id="email">
										<span v-if="errors.email"class="m-form__help">{{ errors.email[0] }}</span>
									</div>
								</div>

								<div class="form-group m-form__group row">
									<label class="col-lg-2 col-form-label" for="logo">{{ trans.get('universal.logo') }}</label>
									<div class="col-lg-8">
										<input type="file" class="form-control m-input" v-on:change="onFileChange('company', 'logo')" id="logo">
										<span v-if="errors.logo"class="m-form__help">{{ errors.logo[0] }}</span>
									</div>
								</div>
							</div>
						</form>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button v-if="editing" type="button"
							v-bind:class="{'m-btn m-loader m-loader--light m-loader--right': saving}"
							class="btn btn-primary"
						 	@click="editCompany"
						 	:disabled="saving"
						 	>
							{{ trans.get('universal.edit') }}
						</button>

						<button v-else type="button" class="btn btn-primary"
							v-bind:class="{'m-btn m-loader m-loader--light m-loader--right': saving}" 
							@click="createCompany"
							:disabled="saving"
							>
							{{ trans.get('universal.create') }}
						</button>
					</div>
				</div>
			</div>
		</div>

		<!--end::Modal-->
	</div>
</template>

<script>
	import {onFileChange} from '../../../Helpers'
	import {setFileValue} from '../../../Helpers'

	class Company{
		constructor(company){
			this.id = company.id || '';
			this.name = company.name || '';
			this.logo = '';
			this.email = company.email || '';
			this.address = company.address || '';
			this.phone = company.phone || '';
			this.category_id = company.category_id || '';
			this.city_id = company.city_id || '';
			this.quarter_id = company.quarter_id || 0;
		}
	}

	export default{
		props: ['geos', 'categories'],
		data(){
			return {
				quarters: {},
				company: {},
				errors: {},
				editing: false,
				saving: false,
			}
		},
		mounted(){
			this.$parent.$on('create_company', () => {
				this.setFileValue('#logo', '', 'company', 'logo');
				this.editing = false;
				this.company = new Company({});
				this.errors = {};

				this.quarters = {};
			});

			this.$parent.$on('edit_company', ({company}) => {
				this.setFileValue('#logo', '', 'company', 'logo');
				this.editing = true;
				this.company = new Company(company);
				this.errors = {};

				this.$helpers.changeSelect('#city_id', this.company.city_id);
				this.changeCity(true);
				this.$helpers.changeSelect('#quarter_id', this.company.quarter_id);
			});
		},
		methods: {
			createCompany(){
				this.saving = true;
				axios.post('/api/companies', this.company)
				.then(response => {
					this.saving = false;
					this.$parent.$emit('company_created', response.data.data);

					this.$helpers.modalHide('#m_modal_create_company');
					
				}).catch(error => {
					this.saving = false;
					this.errors = error.response.data.errors;
				});
			},
			editCompany(){
				this.saving = true;
				axios.put('/api/companies/' + this.company.id, this.company)
				.then(response => {
					this.saving = false;
					this.$parent.$emit('company_updated', response.data.data);

					this.$helpers.modalHide('#m_modal_create_company');
					
				}).catch(error => {
					this.saving = false;
					this.errors = error.response.data.errors;
				});
			},
			changeCity(edit=false){
				if(edit === false){
					this.company.quarter_id = 0;
				}
				this.quarters = {};

				var city_id = this.company.city_id;

				for(var g in this.geos){
					if(this.geos[g].id == city_id) this.quarters = this.geos[g].quarters;
				}
			},
			onFileChange,
			setFileValue
		}
	}
</script>