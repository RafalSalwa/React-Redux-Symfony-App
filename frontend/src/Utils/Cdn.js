
const API_URL = 'http://localhost:8000';

class CdnUtils {
    static getPhotoUrl(filename) {
        return `${API_URL}/${filename}`;
    }
}
export default CdnUtils;