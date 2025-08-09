export interface HomeService {
  id: number;
  price: number;
  duration: number;
  name: string;
  slug: string;
  is_popular: boolean;
  // type data category sama dengan objek category karena satu data home service hanya memiliki satu category
  category: Category;
  thumbnail: string;
  // dalam kurung atau array type datanya karena satu home service bisa memiliki banyak benefit
  benefits: Benefit[];
  // dalam kurung atau array type datanya karena satu home service bisa memiliki banyak testimonial
  testimonials: Testimonial[];
  about: string;
}

export interface Category {
  id: number;
  name: string;
  slug: string;
  photo: string;
  home_services_count: number;
  // dalam kurung dengan tipe data array karena satu category bisa memiliki banyak home service
  home_services: HomeService[];
  popular_services: HomeService[];
}

interface Benefit {
  id: number;
  name: string;
}

interface Testimonial {
  id: number;
  name: string;
  message: string;
  photo: string;
}

export interface BookingDetails {
  id: number;
  name: string;
  phone: string;
  email: string;
  city: string;
  address: string;
  post_code: string;
  started_time: String;
  proof: string;
  schedule_at: string;
  sub_total: number;
  total_tax_amount: number;
  total_amount: number;
  is_paid: boolean;
  booking_trx_id: string;
  transaction_details: TransactionDetails[];
}

interface TransactionDetails {
  id: number;
  price: number;
  home_service_id: number;
  home_service: HomeService;
}

// interface untuk fitur Cart Item
export interface CartItem {
  service_id: number;
  slug: string;
  quantity: number;
}

export type BookingFormData = {
  name: string;
  email: string;
  phone: string;
  city: string;
  address: string;
  post_code: string;
  started_time: string;
  schedule_at: string;
};
