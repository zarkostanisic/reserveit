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
						<form class="m-form m-form--fit m-form--label-align-right">
							<div class="m-form__section m-form__section--first">
								<div class="form-group m-form__group row">
									<label for="name" class="col-lg-2 col-form-label">{{ trans.get('universal.name') }}</label>
									<div class="col-lg-8">
										<input v-model="company.name" type="text" class="form-control m-input" placeholder="" id="name">
										<span v-if="errors.name"class="m-form__help">{{ errors.name[0] }}</span>
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
						 	>
							{{ trans.get('universal.edit') }}
						</button>

						<button v-else type="button" class="btn btn-primary"
							v-bind:class="{'m-btn m-loader m-loader--light m-loader--right': saving}" 
							@click="createCompany"
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
	class Company{
		constructor(company){
			this.id = company.id || '';
			this.name = company.name || '';
		}
	}

	export default{
		data(){
			return {
				company: {},
				errors: {},
				editing: false,
				saving: false
			}
		},
		mounted(){
			this.$parent.$on('create_company', () => {
				this.editing = false;
				this.company = new Company({});
				this.errors = {};
			});

			this.$parent.$on('edit_company', ({company}) => {
				this.editing = true;
				this.company = new Company(company);
				this.errors = {};
			});

		},
		methods: {
			createCompany(){
				this.saving = true;
				axios.post('/api/companies', this.company)
				.then(response => {
					this.saving = false;
					this.$parent.$emit('company_created', response.data.data);

					this.modalHide();
					
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

					this.modalHide();
					
				}).catch(error => {
					this.saving = false;
					this.errors = error.response.data.errors;
				});
			},
			modalHide(){
				$('#m_modal_create_company').modal('hide');
			}
		}
	}
</script>