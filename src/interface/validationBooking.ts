import { z } from "zod";

export const bookingSchema = z.object({
  name: z.string().min(3, "Name is required"),
  email: z.email("Email is required"),
  phone: z.string().min(1, "Phone is required"),
  started_time: z.string().min(1, "Started time is required"),
  schedule_at: z.string().min(1, "Schedule date is required"),
  post_code: z.string().min(1, "Post code is required"),
  address: z.string().min(1, "Address is required"),
  city: z.string().min(1, "City is required"),
});

export const paymentSchema = z.object({
  // instanceof itu berarrti harus file data yang dikirm dari frontEnd kepada Backend
  proof: z
    .instanceof(File)
    // refine adalah validasi untuk jenis file yang dikirim dan ukuran file
    .refine((file) => file.size > 0, "Proof Payment is required")
    .refine(
      (type) =>
        type.type === "image/jpeg" ||
        type.type === "image/png" ||
        type.type === "image/jpg" ||
        type.type === "image/webp" ||
        type.type === "image/svg" ||
        type.type === "image/gif",
      "Proof Payment must be JPEG, PNG, JPG, WEBP, SVG, or GIF"
    ),
});

export const viewBookingSchema = z.object({
  booking_trx_id: z.string().min(1, "Booking Transaction ID is required"),
  email: z.email("Email is required"),
});
