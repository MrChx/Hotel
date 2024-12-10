import HotelCard from "../components/HotelCard";
import { useEffect, useState } from "react";
import { Hotel } from "../types/Data";
import { Link } from "react-router-dom";
import apiClient from "../service/ApiService";

export default function BrowseHotelWrapper() {
  const [hotels, setHotel] = useState<Hotel[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    apiClient
      .get("/hotels")
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
        <Link key={hotel.id} to={`/hotel/${hotel.slug}`}>
        <HotelCard hotel={hotel} ></HotelCard>
        </Link>
      ))}
        
      </div>
    </section>
  );
}
