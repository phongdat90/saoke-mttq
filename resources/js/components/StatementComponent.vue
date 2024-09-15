<template>
    <section class="bg-light py-3 py-md-5">
        <div class="container mb-3">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
                    <h2 class="mb-4 display-5 text-center">Check var sao kê.</h2>
                    <br>
                    Bản Quyền thuộc phongdat developer
                    <br>
                    Tất cả dữ liệu đều được trích xuất từ sao kê MTTQ.
                    <br>
                    Vui lòng không chỉnh sửa dữ liệu để phục vụ mục đích cá nhân
                    <br>
                    Dữ liệu chỉ mang tính chất tham khảo
                </div>
            </div>
        </div>

        <div class="container vl-parent">
            <div class="row justify-content-lg-center">
                <div class="col-12 col-lg-9">
                    <div class="bg-white border rounded shadow-sm overflow-hidden">

                        <div class="form">
                            <div class="row gy-4 gy-xl-5 p-4 p-xl-5">

                                <div class="col-12 col-md-6">
                                    <input type="email" class="form-control" v-model="params.send_by" placeholder="Nhập tên">
                                </div>

                                <div class="col-12 col-md-6">
                                    <input type="email" v-model="params.transaction_id" class="form-control"  placeholder="Nhập mã giao dịch">
                                </div>

                                <div class="col-12">
                                    <textarea class="form-control" v-model="params.description" placeholder="Nhập nội dung ck"></textarea>
                                </div>
                                <button @click="fetchData" class="col-12 col-md-6 btn btn-primary ml-2" type="button">Tìm kiếm</button>
                                <button @click="cancelFilter" class="col-12 col-md-6 btn btn-light" type="button">Bỏ tìm kiếm</button>
                            </div>
                        </div>

                        <loading v-model:active="isLoading" :is-full-page="fullPage"/>

                        <div class="gy-4 gy-xl-5 p-4 p-xl-5 table-responsive">
                            <div class="table-responsive">
                                <table class="table">
                                    <caption>
                                        <nav aria-label="...">
                                            <ul class="pagination pagination-sm">
                                                <li class="page-item" v-for="n in rangeWithDots">
                                                    <a class="page-link" @click="changePage(n)" tabindex="-1">{{ n }}</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </caption>
                                    <thead>
                                    <tr>
                                        <th>Ngày</th>
                                        <th>Mã GD</th>
                                        <th style="width:100px">Số tiền</th>
                                        <th>Nội dung</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item in statements.data">
                                        <td style="width: 120px">{{ item.send_at }}</td>
                                        <td>{{ item.transaction_id }}</td>
                                        <td>{{ item.amount.toLocaleString('en-IN') }} đ</td>
                                        <td>{{ item.description }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';
import useStatement from "../composables/statement";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';

const params = reactive({
    page: 1,
    description: '',
    transaction_id: '',
    send_at: '',
    send_by: '',
});

const fullPage = ref(false)

const isLoading = ref(true)

const showNotice = ref(true)

const changePage = (number) => {
    params.page = number;
    fetchData()
}

const cancelFilter = () => {
    params.page = 1;
    params.description = '';
    params.transaction_id = '';
    params.send_at = '';
    params.send_by = '';

    fetchData();
}

const remove = () => {
    showNotice.value = false
}

const { getStatements, statements,  rangeWithDots, currentPage } = useStatement()

defineOptions({
    name: 'StatementComponent'
})

onMounted(
    () => fetchData())

const fetchData = async () => {
    isLoading.value = true;
    await getStatements(params);
    isLoading.value = false;
}
</script>

<style scoped>
ul {
    list-style: none!important;
}
.pagination-list .pagination-link {
    color: #60c0bd !important;
}
.pagination-link {
    background-color: #ffffff;
    color: #60c0bd;
}
.pagination-link.is-current {
    background-color: #60c0bd;
    border-color: #60c0bd;
    color: #ffffff !important;
}
</style>


