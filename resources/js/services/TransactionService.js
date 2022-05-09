import Axios from "axios";

/**
 * Return all transactions.
 * @returns Promise<>
 */
 export async function all() {
    return Axios.get('/transactions');
}

/**
 * Store a transaction.
 * @param array data 
 * @returns Promise<>
 */
export async function store(data) {
    return Axios.post('/transactions', data);
}

/**
 * Update a transaction.
 * @param int id
 * @param array data 
 * @returns Promise<>
 */
 export async function update(id, data) {
    return Axios.put(`/transactions/${id}`, data);
}

/**
 * Delete a transaction entry.
 * @param int id 
 * @returns Promise <>
 */
export async function destroy(id) {
    return Axios.delete(`/transactions/${id}`);
}

/**
 * Upload a CSV file import.
 * @param \File file 
 * @returns Promise <>
 */
export async function uploadImport(file) {
    var payload = new FormData();
    payload.append('csv', file);
    return Axios.post('/transactions/import', payload, { headers: { 'Content-Type': 'multipart/form-data' } });
}
