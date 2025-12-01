// resources/js/services/api.js

const BASE_URL = 'http://osismaarif.test/api'

export const api = {
  async get(url) {
    const response = await fetch(`${BASE_URL}${url}`)
    return await response.json()
  },

  async post(url, data) {
    const response = await fetch(`${BASE_URL}${url}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify(data)
    })
    return await response.json()
  },

  async put(url, data) {
    const response = await fetch(`${BASE_URL}${url}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify(data)
    })
    return await response.json()
  },

  async delete(url) {
    const response = await fetch(`${BASE_URL}${url}`, {
      method: 'DELETE',
      headers: {
        'Accept': 'application/json',
      }
    })
    return await response.json()
  }
}