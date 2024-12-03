import './App.css'
import { BrowserRouter, Route, Routes } from 'react-router-dom'
import Browse from './pages/Browse'
import CityDetaills from './pages/CityDetails'
import Details from './pages/Details'
import BookHotel from './pages/BookHotel'
import SuccesBooking from './pages/SuccesBooking'
import CheckBooking from './pages/CheckBooking'

function App() {

  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Browse />}/>
        <Route path="/hotel/:slug" element={<Details />}/>
        <Route path="hotel/:slug/book" element={<BookHotel/>}/>
        <Route path="city/:slug" element={<CityDetaills/>}/>
        <Route path="/success-booking" element={<SuccesBooking/>}/>
        <Route path="/check-booking" element={<CheckBooking/>}/> 
      </Routes>
    </BrowserRouter>
  )
}

export default App
