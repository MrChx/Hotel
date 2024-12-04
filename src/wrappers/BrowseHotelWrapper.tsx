import HotelCard from "../components/HotelCard";
import { useEffect, useState } from "react";
import { Hotel } from "../types/Data";
import axios from "axios";

export default function BrowseHotelWrapper() {
  const [hotels, setHotel] = useState<Hotel[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    axios
      .get("http://127.0.0.1:8000/api/hotels", {
        headers: {
          "X-API-KEY": "LaRaVeL11ReAcT19Ts",
        },
      })
      .then((response) => {
        setHotel(response.data.data);
        setLoading(false);
      })
      .catch((err) => {
        setError(err.message || "An unexpected error occurred");
        setLoading(false);
      });
  }, []);

  if (loading) {
    return <p>Loading...</p>;
  }

  if (error) {
    return <p>Error: {error}</p>;
  }

  return (
    <section
      id="Fresh-Space"
      className="flex flex-col gap-[30px] w-full max-w-[1130px] mx-auto mt-[100px] mb-[120px]"
    >
      <h2 className="font-bold text-[32px] leading-[48px] text-nowrap text-center">
        Browse Our Fresh Space.
        <br />
        For Your Better Productivity.
      </h2>
      <div className="grid grid-cols-3 gap-[30px]">
      {hotels.map((hotel) => (
        <HotelCard key={hotel.id} hotel={hotel} ></HotelCard>
      ))}
        
      </div>
    </section>
  );
}
