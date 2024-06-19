
const API_BASE_URL = process.env.REACT_APP_API_BASE_URL || 'http://0.0.0.0:8000';

class CdnUtils {
    static getPhotoUrl(filename) {
        return `${API_BASE_URL}/${filename}`;
    }
}
export default CdnUtils;