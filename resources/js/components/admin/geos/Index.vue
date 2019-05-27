<template>
	<div> 
		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							{{ trans.get('geos.list') }}
						</h3>
					</div>
				</div>
				<div class="m-portlet__head-tools">
					<ul class="m-portlet__nav">
						<li class="m-portlet__nav-item">
							<button @click.prevent="createGeo" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--air" data-toggle="modal" data-target="#m_modal_create_geo">
								<span>
									<i class="la la-plus"></i>
									<span>{{ trans.get('geos.singular') }}</span>
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

						<label class="col-sm-12 col-md-2">
							{{ trans.get('universal.name') }} 

							<input type="text" 
								class="form-control form-control-sm" v-bind:value="name" 
								@input="name = $event.target.value"
								@keyup="searchByName()"
								:disabled="loading"
								>
						</label>

						<label class="col-sm-12 col-md-2">{{ trans.get('universal.city') }}
							<select class="form-control form-control-sm custom-select custom-select-sm" v-model="city_id" @change="getAllWithFilter" :disabled="loading">
								<option value="0">
									{{ trans.get('universal.choose') }}
								</option>
								<option v-for="city in cities" :value="city.id">
									{{ city.name }}
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
							<th 
								:class="orderActive('name')" 
								@click="orderBy('name')">{{ trans.get('universal.name') }}</th>
							<th 
								:class="orderActive('type')" 
								@click="orderBy('type')">{{ trans.get('universal.type') }}</th>
							<th>{{ trans.get('universal.status') }}</th>
							<th>{{ trans.get('universal.actions') }}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="geo, key in geos.data">
							<th scope="row">{{ geo.id }}</th>
							<td>
								<div v-if="geo.city_id > 0">
									{{ geo.name }}
									<span class="m-badge m-badge--brand m-badge--wide">{{ geo.city.name }}</span>
								</div>
								<span v-else>{{ geo.name }}</span>
							</td>
							<th scope="row">{{ trans.get('universal.' + geo.type) }}</th>
							<td>
								<span v-if="geo.deleted" class="m-badge m-badge--danger m-badge--wide">	
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
											data-target="#m_modal_create_geo"
											@click="editGeo(geo)">
											{{ trans.get('universal.edit') }}
										</button>
									</div>

									<div class="m-stack__item">

										<button type="button" class="btn" 
											v-if="$gate.isAdmin()"
											v-bind:class="{ 'btn-outline-danger': !geo.deleted, 'btn-outline-success': geo.deleted}" 
										 	@click="deleteGeo(geo.id, key)">
											{{ geo.deleted ? trans.get('universal.restore') : trans.get('universal.delete') }}
										</button>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

				<pagination :limit="3" :data="geos" @pagination-change-page="getAllWithFilter" align="right"></pagination>
			</div>

			<BlockUI v-if="loading">
			  <div class="m-loader m-loader--brand" style="width: 30px; display: inline-block;">
			  </div>
			</BlockUI>

			<admin-geos-create :cities="cities" :types="types"></admin-geos-create>
		</div>
	</div>
</template>

<script>
	import AdminGeosCreate from './Create'	
	import {orderBy} from '../../../Helpers'
	import {orderActive} from '../../../Helpers'

	let timeout = null;

	export default {
		props: ['types', 'cities'],
		components: {
		    AdminGeosCreate
		},
		data() {
			return {
				geos: {},
				perpage: 25,
				orderField: 'id',
				order: 'asc',
				loading: false,
				name: '',
				city_id: 0
			}
		},
		mounted() {

			this.getAllWithFilter();

			this.$on('geo_created', (geo) => {
				this.geos.data.unshift(geo);
				
				if(geo.type == 'city') this.cities.unshift(geo);

				window.noty(this.trans.get('universal.success'), 'success');
			});

			this.$on('geo_updated', (geo) => {
				let geoIndex = this.geos.data.findIndex(g => {
					return geo.id == g.id;
				});

				let cityIndex = this.cities.findIndex(c => {
					return geo.id == c.id;
				});

				this.geos.data.splice(geoIndex, 1, geo);
				
				if(geo.type == 'city' && cityIndex == -1) this.cities.unshift(geo);
				else if(geo.type == 'quarter') this.cities.splice(cityIndex, 1);

				window.noty(this.trans.get('universal.success'), 'success');
			});
		},
		methods: {
			getAllWithFilter(page = 1) {
				this.loading = true;

				var ajax_url = '/api/geos?page=' + page 
				ajax_url += '&perpage=' + this.perpage;
				ajax_url += '&orderBy=' + this.orderField;
				ajax_url += '&order=' + this.order;
				if(this.name != '') ajax_url += '&name=' + this.name;
				if(this.city_id != '0') ajax_url += '&city_id=' + this.city_id;

				axios.get(ajax_url)
				.then(response => {
					$(document).scrollTop(0);
					this.loading = false;

					this.geos = response.data;
				});
			},

			createGeo(){
				this.$emit('create_geo');
			},

			editGeo(geo){
				this.$emit('edit_geo', {geo});
			},

			deleteGeo(id, key) {
				if(confirm(this.trans.get('universal.confirm'))){
					this.loading = true;

					var ajax_url = '/api/geos/' + id;

					axios.delete(ajax_url)
					.then(response => {
						this.loading = false;

						this.geos.data.splice(key, 1, response.data.data);

						let cityIndex = this.cities.findIndex(c => {
							return response.data.data.id == c.id;
						});

						if(response.data.data.deleted) this.cities.splice(cityIndex, 1);
						else this.cities.unshift(response.data.data);

						window.noty(this.trans.get('universal.success'), 'success');
					});
				}
			},
			searchByName(){
				clearTimeout(timeout);

				timeout = setTimeout(() => {
					this.getAllWithFilter();
				}, 500);
			},
			orderBy,
			orderActive
		}

	}
</script>