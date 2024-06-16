import {fetchUser, logoutUser} from "../services/api";

export async function registration(data) {
}

export async function login(data) {
}

export async function logoutCurrentUser(data) {
    return await logoutUser();
}

export async function getCurrentUser() {
    return await fetchUser();
}
