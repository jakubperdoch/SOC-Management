<script setup lang="ts">
	import auth from '~/middleware/auth';

	definePageMeta({
		layout: 'default',
		middleware: [auth],
	});
</script>

<template>
	<!-- Start::row-1 -->
	<section
		class="tw-p-9 tw-flex tw-flex-col lg:tw-grid lg:tw-grid-cols-4 tw-gap-8">
		
		<div class="card custom-card tw-col-span-3">
			<div class="card-header justify-content-between">
				<div class="card-title">Deals Statistics</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table text-nowrap table-hover border table-bordered">
						<thead>
							<tr>
								<th
									scope="row"
									class="ps-4">
									<input
										class="form-check-input"
										type="checkbox"
										id="checkboxNoLabel1"
										value=""
										aria-label="..." />
								</th>
								<th scope="col">Sales Rep</th>
								<th scope="col">Category</th>
								<th scope="col">Mail</th>
								<th scope="col">Location</th>
								<th scope="col">Date</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th
									scope="row"
									class="ps-4">
									<input
										class="form-check-input"
										type="checkbox"
										id="checkboxNoLabel2"
										value=""
										aria-label="..." />
								</th>
								<td>
									<div class="d-flex align-items-center fw-semibold">Mayor Kelly</div>
								</td>
								<td>Manufacture</td>
								<td>mayorkelly@gmail.com</td>
								<td>
									<span class="badge bg-info-transparent">Germany</span>
								</td>
								<td>Sep 15 - Oct 12, 2023</td>
								<td>
									<div class="hstack gap-2 fs-15">
										<a
											aria-label="anchor"
											href="javascript:void(0);"
											class="btn btn-icon btn-wave waves-effect waves-light btn-sm btn-success-light"
											><i class="ri-download-2-line"></i
										></a>
										<a
											aria-label="anchor"
											href="javascript:void(0);"
											class="btn btn-icon btn-wave waves-effect waves-light btn-sm btn-primary-light"
											><i class="ri-edit-line"></i
										></a>
									</div>
								</td>
							</tr>
							<tr>
								<th
									scope="row"
									class="ps-4">
									<input
										class="form-check-input"
										type="checkbox"
										id="checkboxNoLabel13"
										value=""
										aria-label="..."
										checked />
								</th>
								<td>
									<div class="d-flex align-items-center fw-semibold">
										Andrew Garfield
									</div>
								</td>
								<td>Development</td>
								<td>andrewgarfield@gmail.com</td>
								<td>
									<span class="badge bg-primary-transparent">Canada</span>
								</td>
								<td>Apr 10 - Dec 12, 2023</td>
								<td>
									<div class="hstack gap-2 fs-15">
										<a
											aria-label="anchor"
											href="javascript:void(0);"
											class="btn btn-icon waves-effect waves-light btn-sm btn-success-light"
											><i class="ri-download-2-line"></i
										></a>
										<a
											aria-label="anchor"
											href="javascript:void(0);"
											class="btn btn-icon waves-effect waves-light btn-sm btn-primary-light"
											><i class="ri-edit-line"></i
										></a>
									</div>
								</td>
							</tr>
							<tr>
								<th
									scope="row"
									class="ps-4">
									<input
										class="form-check-input"
										type="checkbox"
										id="checkboxNoLabel4"
										value=""
										aria-label="..." />
								</th>
								<td>
									<div class="d-flex align-items-center fw-semibold">Simon Cowel</div>
								</td>
								<td>Service</td>
								<td>simoncowel234@gmail.com</td>
								<td>
									<span class="badge bg-danger-transparent">Europe</span>
								</td>
								<td>Sep 15 - Oct 12, 2023</td>
								<td>
									<div class="hstack gap-2 fs-15">
										<a
											aria-label="anchor"
											href="javascript:void(0);"
											class="btn btn-icon waves-effect waves-light btn-sm btn-success-light"
											><i class="ri-download-2-line"></i
										></a>
										<a
											aria-label="anchor"
											href="javascript:void(0);"
											class="btn btn-icon waves-effect waves-light btn-sm btn-primary-light"
											><i class="ri-edit-line"></i
										></a>
									</div>
								</td>
							</tr>
							<tr>
								<th
									scope="row"
									class="ps-4">
									<input
										class="form-check-input"
										type="checkbox"
										id="checkboxNoLabel5"
										value=""
										aria-label="..."
										checked />
								</th>
								<td>
									<div class="d-flex align-items-center fw-semibold">Mirinda Hers</div>
								</td>
								<td>Marketing</td>
								<td>mirindahers@gmail.com</td>
								<td>
									<span class="badge bg-warning-transparent">USA</span>
								</td>
								<td>Apr 14 - Dec 14, 2023</td>
								<td>
									<div class="hstack gap-2 fs-15">
										<a
											aria-label="anchor"
											href="javascript:void(0);"
											class="btn btn-icon waves-effect waves-light btn-sm btn-success-light"
											><i class="ri-download-2-line"></i
										></a>
										<a
											aria-label="anchor"
											href="javascript:void(0);"
											class="btn btn-icon waves-effect waves-light btn-sm btn-primary-light"
											><i class="ri-edit-line"></i
										></a>
									</div>
								</td>
							</tr>
							<tr>
								<th
									scope="row"
									class="ps-4">
									<input
										class="form-check-input"
										type="checkbox"
										id="checkboxNoLabel3"
										value=""
										aria-label="..."
										checked />
								</th>
								<td>
									<div class="d-flex align-items-center fw-semibold">Jacob Smith</div>
								</td>
								<td>Social Plataform</td>
								<td>jacobsmith@gmail.com</td>
								<td>
									<span class="badge bg-success-transparent">Singapore</span>
								</td>
								<td>Feb 25 - Nov 25, 2023</td>
								<td>
									<div class="hstack gap-2 fs-15">
										<a
											aria-label="anchor"
											href="javascript:void(0);"
											class="btn btn-icon waves-effect waves-light btn-sm btn-success-light"
											><i class="ri-download-2-line"></i
										></a>
										<a
											aria-label="anchor"
											href="javascript:void(0);"
											class="btn btn-icon waves-effect waves-light btn-sm btn-primary-light"
											><i class="ri-edit-line"></i
										></a>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer">
				<div class="d-flex align-items-center">
					<div>
						Showing 5 Entries <i class="bi bi-arrow-right ms-2 fw-semibold"></i>
					</div>
					<div class="ms-auto">
						<nav
							aria-label="Page navigation"
							class="pagination-style-4">
							<ul class="pagination mb-0">
								<li class="page-item disabled">
									<a
										class="page-link"
										href="javascript:void(0);">
										Prev
									</a>
								</li>
								<li class="page-item active">
									<a
										class="page-link"
										href="javascript:void(0);"
										>1</a
									>
								</li>
								<li class="page-item">
									<a
										class="page-link"
										href="javascript:void(0);"
										>2</a
									>
								</li>
								<li class="page-item">
									<a
										class="page-link text-primary"
										href="javascript:void(0);">
										next
									</a>
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
		<div class="card custom-card tw-col-start-4 tw-col-span-1">
			<div class="card-header justify-content-between">
				<div class="card-title">Deals Status</div>
				<div class="dropdown">
					<a
						href="javascript:void(0);"
						class="p-2 fs-12 text-muted"
						data-bs-toggle="dropdown"
						aria-expanded="false">
						View All<i class="ri-arrow-down-s-line align-middle ms-1"></i>
					</a>
					<ul
						class="dropdown-menu"
						role="menu">
						<li>
							<a
								class="dropdown-item"
								href="javascript:void(0);"
								>Today</a
							>
						</li>
						<li>
							<a
								class="dropdown-item"
								href="javascript:void(0);"
								>This Week</a
							>
						</li>
						<li>
							<a
								class="dropdown-item"
								href="javascript:void(0);"
								>Last Week</a
							>
						</li>
					</ul>
				</div>
			</div>
			<div class="card-body">
				<div class="d-flex align-items-center mb-3">
					<h4 class="fw-bold mb-0">4,289</h4>
					<div class="ms-2">
						<span class="badge bg-success-transparent"
							>1.02<i class="ri-arrow-up-s-fill align-mmiddle ms-1"></i
						></span>
						<span class="text-muted ms-1">compared to last week</span>
					</div>
				</div>
				<div class="progress-stacked progress-animate progress-xs mb-4">
					<div
						class="progress-bar"
						role="progressbar"
						style="width: 21%"
						aria-valuenow="21"
						aria-valuemin="0"
						aria-valuemax="100"></div>
					<div
						class="progress-bar bg-info"
						role="progressbar"
						style="width: 26%"
						aria-valuenow="26"
						aria-valuemin="0"
						aria-valuemax="100"></div>
					<div
						class="progress-bar bg-warning"
						role="progressbar"
						style="width: 35%"
						aria-valuenow="35"
						aria-valuemin="0"
						aria-valuemax="100"></div>
					<div
						class="progress-bar bg-success"
						role="progressbar"
						style="width: 18%"
						aria-valuenow="18"
						aria-valuemin="0"
						aria-valuemax="100"></div>
				</div>
				<ul class="list-unstyled mb-0 pt-2 crm-deals-status">
					<li class="primary">
						<div class="d-flex align-items-center justify-content-between">
							<div>Successful Deals</div>
							<div class="fs-12 text-muted">987 deals</div>
						</div>
					</li>
					<li class="info">
						<div class="d-flex align-items-center justify-content-between">
							<div>Pending Deals</div>
							<div class="fs-12 text-muted">1,073 deals</div>
						</div>
					</li>
					<li class="warning">
						<div class="d-flex align-items-center justify-content-between">
							<div>Rejected Deals</div>
							<div class="fs-12 text-muted">1,674 deals</div>
						</div>
					</li>
					<li class="success">
						<div class="d-flex align-items-center justify-content-between">
							<div>Upcoming Deals</div>
							<div class="fs-12 text-muted">921 deals</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</section>
	<!-- End::row-1 -->
</template>

<style>
	.apexcharts-radialbar-hollow {
		fill: transparent !important;
	}
</style>
