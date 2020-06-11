
export function postIntegrate(formData) {
  let config = {
  }
  return axios.post('/api/v1/users/integrate', formData, config).then(res => {res.data})  // eslint-disable-line
}