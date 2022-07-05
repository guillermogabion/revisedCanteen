import axios from '@/plugins/axios';

export const getAllMeal = () => axios.get('getAllMeal')
export const mealPagination = (url, payload) => axios.get(`/${url}`, payload)
export const searchMeal = (payload) => axios.post('searchMeal', payload)