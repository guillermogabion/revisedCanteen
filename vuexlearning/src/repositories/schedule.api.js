import axios from '@/plugins/axios';

export const getScheduledDish = () => axios.get('getScheduledDish')
export const addDishSchedule = (editedItem) =>axios.post('addDishSchedule', editedItem)