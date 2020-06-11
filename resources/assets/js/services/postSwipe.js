
export function postSwipe(formData) {
  let config = {
  }
  return axios.post('/api/v1/users/swipe', formData, config).then(res => {res.data})  // eslint-disable-line
}