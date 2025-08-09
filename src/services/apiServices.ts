import axios, { AxiosError } from "axios";

const BASE_URL_API = import.meta.env.VITE_BASE_URL_API;

const apiClient = axios.create({
  baseURL: BASE_URL_API,
  headers: {
    Accept: "application/json",
  },
});

export const isAxiosError = axios.isAxiosError;

export default apiClient;
