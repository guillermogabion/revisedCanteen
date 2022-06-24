import axios from '@/plugins/axios';

export const Self = () => axios.get('self')
export const login = (payload) => axios.post('login', payload)
export const addUsers = (payload)=>axios.post('saveNew', payload)
export const editUser = (id, payload)=>axios.post(`editUser/${id}`, payload)
export const userPagination = (url,payload) => axios.get(`/${url}`, payload)
export const searchUser = (payload) => axios.post('searchUser', payload)
export const deleteUser = (id)=>axios.delete(`deleteUser/${id}`)


