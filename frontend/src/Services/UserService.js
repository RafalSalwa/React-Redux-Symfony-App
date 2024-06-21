import {fetchUser, logoutUser} from "./api";

export async function login(data) {
}

export async function logoutCurrentUser(data) {
    return await logoutUser();
}

export async function getCurrentUser() {
    return await fetchUser();
}