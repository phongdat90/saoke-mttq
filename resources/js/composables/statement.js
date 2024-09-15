import { ref } from "vue";
import { apiRequest, buildParams } from "../helpers/apiRequest";
import { pagination } from "../helpers/pagination";


export default function useStatement() {
    const statements = ref([]);
    const rangeWithDots = ref([])
    const currentPage = ref(1)

    const getStatements = async (params) => {
        let url = '/api/statement' + buildParams(params) ;
        let response = await apiRequest(url, 'GET');
        statements.value = response.data;
        rangeWithDots.value = pagination(response.data.current_page, response.data.last_page);
        currentPage.value = response.data.current_page;
    };

    return {
        getStatements,
        statements,
        rangeWithDots,
        currentPage
    }
}
