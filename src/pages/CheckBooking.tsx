export default function CheckBooking() {
  return (
    <>
      <nav className="bg-white">
        <div className="flex items-center justify-between w-full max-w-[1130px] py-[22px] mx-auto">
          <a href="index.html">
            <img src="/assets/images/logos/logo.svg" alt="logo" />
          </a>
          <ul className="flex items-center gap-[50px] w-fit">
            <li>
              <a href="">Browse</a>
            </li>
            <li>
              <a href="">Popular</a>
            </li>
            <li>
              <a href="">Categories</a>
            </li>
            <li>
              <a href="">Events</a>
            </li>
            <li>
              <a href="view-booking-details.html">My Booking</a>
            </li>
          </ul>
          <a
            href="#"
            className="flex items-center gap-[10px] rounded-full border border-[#000929] py-3 px-5"
          >
            <img
              src="/assets/images/icons/call.svg"
              className="w-6 h-6"
              alt="icon"
            />
            <span className="font-semibold">Contact Us</span>
          </a>
        </div>
      </nav>
      <div
        id="Banner"
        className="relative w-full h-[240px] flex items-center shrink-0 overflow-hidden -mb-[50px]"
      >
        <h1 className="text-center mx-auto font-extrabold text-[40px] leading-[60px] text-white mb-5 z-20">
          View Your Booking Details
        </h1>
        <div className="absolute w-full h-full bg-[linear-gradient(180deg,_rgba(0,0,0,0)_0%,#000000_91.83%)] z-10" />
        <img
          src="/assets/images/thumbnails/thumbnail-details-5.png"
          className="absolute w-full h-full object-cover object-top"
          alt=""
        />
      </div>
    </>
  );
}
