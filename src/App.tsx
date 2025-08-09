import { BrowserRouter, Route, Routes } from "react-router-dom";
import HomePage from "./pages/HomePage";
import MyCartPage from "./pages/MyCartPage";
import DetailsPage from "./pages/DetailsPage";
import CategoryPage from "./pages/CategoryPage";
import BookingPage from "./pages/BookingPage";
import SuccessBookingPage from "./pages/SuccessBookingPage";
import PaymentPage from "./pages/PaymentPage";
import MyBookingPage from "./pages/MyBookingPage";

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<HomePage />} />
        <Route path="/cart" element={<MyCartPage />} />
        {/* /service/:slug untuk proses parsing data ke url bahwa akan menggunakan slug dalam proses ,melihat detail data service dari backend */}
        <Route path="/service/:slug" element={<DetailsPage />} />
        <Route path="/category/:slug" element={<CategoryPage />} />
        <Route path="/booking" element={<BookingPage />} />
        <Route path="/payment" element={<PaymentPage />} />
        <Route path="/success-booking" element={<SuccessBookingPage />} />
        <Route path="/my-booking" element={<MyBookingPage />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
